<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Materiais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'Arial', sans-serif;
        }

        main {
            margin-top: 50px;
            padding: 20px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        fieldset {
            border: none;
            margin-bottom: 20px;
        }

        legend {
            font-size: 1.25rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        #resultado p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 8px;
        }

        #resultado {
            padding-top: 20px;
            border-top: 2px solid #007bff;
            margin-top: 20px;
        }

        .col-md-12 {
            margin-top: 10px;
        }

        input[type="number"] {
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
        }
    </style>
</head>

<body>

    <main>
        <h1 class="text-center">Calculadora de Materiais</h1>
        <div class="container">
            <form class="row g-3">
                <fieldset class="row g-3">
                    <legend>Comôdo</legend>
                    <div class="col-md-6">
                        <label for="comodo-largura" class="form-label">Largura(m)</label>
                        <input type="number" class="form-control" id="comodo-largura" required>
                    </div>
                    <div class="col-md-6">
                        <label for="comodo-comprimento" class="form-label">Comprimento(m)</label>
                        <input type="number" class="form-control" id="comodo-comprimento" required>
                    </div>
                </fieldset>
                <fieldset class="row g-3">
                    <legend>Piso</legend>
                    <div class="col-md-6">
                        <label for="piso-largura" class="form-label">Largura(m)</label>
                        <input type="number" class="form-control" id="piso-largura" required>
                    </div>
                    <div class="col-md-6">
                        <label for="piso-comprimento" class="form-label">Comprimento(m)</label>
                        <input type="number" class="form-control" id="piso-comprimento" required>
                    </div>
                </fieldset>
                <div class="col-md-12">
                    <label for="margem" class="form-label">Margem(%)</label>
                    <input type="number" class="form-control" id="margem" required>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary" id="btn-calcular" type="button" onclick="processar();">Calcular</button>
                </div>
                <div class="col-md-12">
                    <div id="resultado"></div>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        function processar() {
            const comodoLargura = parseFloat(document.getElementById("comodo-largura").value);
            const comodoComprimento = parseFloat(document.getElementById("comodo-comprimento").value);
            const pisoLargura = parseFloat(document.getElementById("piso-largura").value);
            const pisoComprimento = parseFloat(document.getElementById("piso-comprimento").value);
            const margem = parseFloat(document.getElementById("margem").value);

            if (comodoLargura <= 0 || comodoComprimento <= 0 || pisoLargura <= 0 || pisoComprimento <= 0) {
                alert("Todas as dimensões devem ser maiores que 0.");
                return;
            }

            if (margem <= 0) {
                alert("A margem deve ser maior que 0.");
                return;
            }

            const medidas = {
                comodoLargura,
                comodoComprimento,
                pisoLargura,
                pisoComprimento,
                margem
            };

            fetch('/calculo.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(medidas)
            })
                .then(resposta => resposta.json())
                .then(resultado => {
                    const elementoResultado = document.getElementById("resultado");
                    elementoResultado.innerHTML = `
                        <p><strong>Área do cômodo:</strong> ${resultado.areacomodo} m²</p>
                        <p><strong>Área do piso:</strong> ${resultado.areaPiso} m²</p>
                        <p><strong>Quantidade de piso:</strong> ${resultado.quantidade}</p>
                        <p><strong>Quantidade para margem:</strong> ${resultado.quantidadeMargem}</p>
                        <p><strong>Total a ser comprado:</strong> ${resultado.quantidadeTotal}</p>
                    `;
                })
                .catch(() => {
                    alert("Ocorreu um erro");
                });
        }
    </script>

</body>

</html>

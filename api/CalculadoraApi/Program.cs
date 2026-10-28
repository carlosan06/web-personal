var builder = WebApplication.CreateBuilder(args);
var app = builder.Build();

app.MapGet("/", () => "API Calculadora funcionando. Usa /api/calculadora?a=10&b=5&op=suma");

// GET /api/calculadora?a=10&b=5&op=suma
// Operaciones válidas: suma, resta, multiplicacion, division
app.MapGet("/api/calculadora", (double? a, double? b, string? op) =>
{
    if (a is null || b is null)
    {
        return Results.BadRequest(new { error = "Debe enviar los parámetros 'a' y 'b' como números." });
    }

    double numero1 = a.Value;
    double numero2 = b.Value;
    string operacion = (op ?? "").Trim().ToLower();

    double resultado;
    switch (operacion)
    {
        case "suma":
            resultado = numero1 + numero2;
            break;
        case "resta":
            resultado = numero1 - numero2;
            break;
        case "multiplicacion":
            resultado = numero1 * numero2;
            break;
        case "division":
            if (numero2 == 0)
            {
                return Results.BadRequest(new { error = "No se puede dividir para cero." });
            }
            resultado = numero1 / numero2;
            break;
        default:
            return Results.BadRequest(new { error = "Operación no válida. Use: suma, resta, multiplicacion o division." });
    }

    return Results.Ok(new { a = numero1, b = numero2, operacion, resultado });
});

app.Run();

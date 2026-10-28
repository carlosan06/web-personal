# Web Personal con Calculadora

Página web personal desarrollada en **HTML, CSS y PHP**, que incluye una **calculadora** cuya lógica está implementada como una **API en C#** (ASP.NET Core). La página PHP envía los números a la API y muestra el resultado.

## Estructura

```
├── api/CalculadoraApi/   API en C# (lógica de la calculadora)
│   └── Program.cs
└── web/                  Página web en PHP
    ├── index.php
    └── css/styles.css
```

## Funcionamiento

1. El usuario ingresa dos números y una operación en el formulario de `index.php`.
2. PHP llama a la API: `GET http://localhost:5000/api/calculadora?a=10&b=5&op=suma`
3. La API en C# calcula y responde en JSON: `{ "a": 10, "b": 5, "operacion": "suma", "resultado": 15 }`
4. PHP muestra el resultado en la página.

Operaciones disponibles: `suma`, `resta`, `multiplicacion`, `division`.
La API valida la división para cero y las operaciones no válidas (responde con código 400).

## Instalación de dependencias

Para desarrollar la tarea se instalaron las siguientes herramientas. El equipo usado es macOS, por lo que la instalación se hizo con el gestor de paquetes **Homebrew**.

| Herramienta | Versión instalada | Uso en el proyecto |
|---|---|---|
| [.NET SDK](https://dotnet.microsoft.com/download) | 10.0 | Crear y ejecutar la API de la calculadora en C# |
| [PHP](https://www.php.net/downloads) | 8.5 | Servir la página web personal |
| [Git](https://git-scm.com/) | — | Control de versiones y publicación en GitHub |
| [Visual Studio Code](https://code.visualstudio.com/) | — | Editor de código |

### Paso 1: Instalar Homebrew

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

### Paso 2: Instalar el SDK de .NET

```bash
brew install --cask dotnet-sdk
```

### Paso 3: Instalar PHP

```bash
brew install php
```

PHP incluye la extensión `curl`, que se usa para que la página llame a la API.

### Paso 4: Verificar la instalación

```bash
dotnet --version
php -v
git --version
```

### Paso 5: Crear el proyecto de la API

```bash
mkdir api && cd api
dotnet new web -n CalculadoraApi
```

Luego se programó la calculadora en `Program.cs` y la página web en `web/index.php`.

> En Windows se puede instalar .NET desde [dotnet.microsoft.com](https://dotnet.microsoft.com/download) y PHP con [XAMPP](https://www.apachefriends.org/).

## Ejecución

Se necesitan dos terminales.

**Terminal 1 – API en C#:**

```bash
cd api/CalculadoraApi
dotnet run
```

La API queda disponible en `http://localhost:5000`.

**Terminal 2 – Web en PHP:**

```bash
cd web
php -S localhost:8000
```

Abrir en el navegador: `http://localhost:8000`

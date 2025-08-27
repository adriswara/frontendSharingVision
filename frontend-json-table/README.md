# Frontend JSON Table Project

This project fetches JSON data from a local server and displays it in a table format. The table includes the following columns: id, title, content, and category.

## Project Structure

```
frontend-json-table
├── src
│   ├── index.html
│   ├── main.js
│   └── styles.css
├── package.json
└── README.md
```

## Getting Started

To run this project, follow these steps:

1. **Clone the repository**:
   ```
   git clone <repository-url>
   cd frontend-json-table
   ```

2. **Install dependencies**:
   Make sure you have Node.js installed. Then run:
   ```
   npm install
   ```

3. **Start the local server**:
   Ensure that your local server is running and serving the JSON data at `http://127.0.0.1:8081/posts`.

4. **Open the project**:
   Open `src/index.html` in your web browser to view the application.

## Features

- Fetches JSON data from a specified endpoint.
- Dynamically generates a table to display the data.
- Responsive design for better user experience.

## License

This project is licensed under the MIT License.
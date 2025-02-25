
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
    <h1>Categories</h1>
    <p>Welcome to the platform.</p>
        <table border="1">
          <thead>
              <tr>
                  <th>Name</th>
                  <th>DisplayOrder</th>
              </tr>
          </thead>
          <tbody>
              <?php
              if (isset($resulter) && !empty($resulter)) {
                  foreach ($resulter as $value) {
                      echo "<tr>
                              <td>{$value->Name}</td>
                              <td>{$value->DisplayOrder}</td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='3'>No data available</td></tr>";
              }
              ?>
          </tbody>
      </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
    <h1>Platform</h1>
    <p>Welcome to the platform.</p>
    <form class="row g-3" method="post">
        <div class="col-auto">
            <label for="staticEmail2" class="visually-hidden">Email</label>
            <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="email@example.com">
        </div>
        <div class="col-auto">
            <label for="inputPassword2" class="visually-hidden">Password</label>
            <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Confirm identity</button>
        </div>
        <table border="1">
          <thead>
              <tr>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Price</th>
                  <!-- Add more columns as needed -->
              </tr>
          </thead>
          <tbody>
              <?php
              if (isset($resulter) && !empty($resulter)) {
                  foreach ($resulter as $value) {
                      echo "<tr>
                              <td>{$value->Title}</td>
                              <td>{$value->Author}</td>
                              <td>{$value->Price}</td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='3'>No data available</td></tr>";
              }
              ?>
          </tbody>
      </table>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
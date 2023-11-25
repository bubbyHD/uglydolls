<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Admin</title>
    <script>
    function toggleTable() {
        var table = document.getElementById("productTable");
        if (table.style.display === "none") {
            table.style.display = "block";
        } else {
            table.style.display = "none";
        }
    }
    </script>
</head>
<body>

<?php
$con=mysqli_connect("localhost","root","","uglydolls");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// insert new data into Producto or update stock
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["update_stock"])) {
        $nombre = $_POST["fnum"];
        $stock_change = $_POST["stock_change"];
        $sql = "UPDATE producto SET stock = stock + '$stock_change' WHERE nombre = '$nombre'";
        if ($con->query($sql) === TRUE) {
            header("Location: " . $_SERVER['REQUEST_URI']); // to same page
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } elseif(isset($_POST["insert_product"])) {
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $foto = $_POST["foto"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $tipo = $_POST["tipo"];

        $sql = "INSERT INTO producto (productonum, nombre, descripcion, foto, precio, stock, tipo)
        VALUES (NULL, '$nombre', '$descripcion', '$foto', '$precio', '$stock', '$tipo')";

        if ($con->query($sql) === TRUE) {
            header("Location: " . $_SERVER['REQUEST_URI']); // to same page
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } elseif(isset($_POST["delete_product"])) {
        $nombre = $_POST["fnum_del"];
        $sql = "DELETE FROM producto WHERE nombre = '$nombre'";
        if ($con->query($sql) === TRUE) {
            header("Location: " . $_SERVER['REQUEST_URI']); // to same page
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } elseif(isset($_POST["update_product"])) {
        $fnum = $_POST["fnum"];
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $foto = $_POST["foto"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $tipo = $_POST["tipo"];

        $sql = "UPDATE producto SET ";
        if (!empty($nombre)) $sql .= "nombre = '$nombre', ";
        if (!empty($descripcion)) $sql .= "descripcion = '$descripcion', ";
        if (!empty($foto)) $sql .= "foto = '$foto', ";
        if (!empty($precio)) $sql .= "precio = '$precio', ";
        if (!empty($stock)) $sql .= "stock = '$stock', ";
        if (!empty($tipo)) $sql .= "tipo = '$tipo', ";
        $sql = rtrim($sql, ', '); // remove trailing comma
        $sql .= " WHERE nombre = '$fnum'";

        if ($con->query($sql) === TRUE) {
            header("Location: " . $_SERVER['REQUEST_URI']); // to same page
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
}

echo "<button onClick='window.location.reload();'>Recargar</button>";
echo "<button onClick='toggleTable()'>Tabla producto</button>"; 
// display all from producto
$result = mysqli_query($con,"SELECT * FROM producto;");
echo "<div id='productTable' style='display: none;'><table border='1'>"; 
echo "<tr>
<th>productonum</th>
<th>nombre</th>
<th>descripcion</th>
<th>foto</th>
<th>precio</th>
<th>stock</th>
<th>tipo</th>
</tr>";

while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['productonum'] . "</td>";
    echo "<td>" . $row['nombre'] . "</td>";
    echo "<td>" . $row['descripcion'] . "</td>";
    echo "<td><img src='https://lab.anahuac.mx/~a00444232/pngs/" . $row['foto'] . "' alt='Product Image' style='max-width:50px; max-height:50px;'></td>";
    echo "<td>" . $row['precio'] . "</td>";
    echo "<td>" . $row['stock'] . "</td>";
    echo "<td>" . $row['tipo'] . "</td>";
    echo "</tr>";
}

echo "</table></div>"; 

mysqli_close($con);
?>

<h1>Pagina de Admin</h1>

<h2>Insertar Nuevos Datos A Producto</h2>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
<label for="nombre">Nombre:</label><br>
<input type="text" id="nombre" name="nombre"><br>
<label for="descripcion">Descripcion:</label><br>
<input type="text" id="descripcion" name="descripcion" maxlength="100"><br>
<label for="foto">Foto:</label><br>
<input type="text" id="foto" name="foto"><br>
<label for="precio">Precio:</label><br>
<input type="text" id="precio" name="precio"><br>
<label for="stock">Stock:</label><br>
<input type="text" id="stock" name="stock"><br>
<label for="tipo">Tipo:</label><br>
<select id="tipo" name="tipo">
  <option value="GUND Keychain Plush">GUND Keychain Plush</option>
  <option value="GUND Regular Plush">GUND Regular Plush</option>
</select><br>
<input type="hidden" name="insert_product" value="1">
<input type="submit" value="Submit">
</form>

<h2>Modificar Datos Existentes De Producto</h2>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
<label for="fnum">Nombre del Producto a Modificar:</label><br>
<input type="text" id="fnum" name="fnum"><br>
<label for="nombre">Nuevo Nombre:</label><br>
<input type="text" id="nombre" name="nombre"><br>
<label for="descripcion">Nueva Descripcion:</label><br>
<input type="text" id="descripcion" name="descripcion" maxlength="100"><br>
<label for="foto">Nueva Foto:</label><br>
<input type="text" id="foto" name="foto"><br>
<label for="precio">Nuevo Precio:</label><br>
<input type="text" id="precio" name="precio"><br>
<label for="stock">Nuevo Stock:</label><br>
<input type="text" id="stock" name="stock"><br>
<label for="tipo">Nuevo Tipo:</label><br>
<select id="tipo" name="tipo">
  <option value="GUND Keychain Plush">GUND Keychain Plush</option>
  <option value="GUND Regular Plush">GUND Regular Plush</option>
</select><br>
<input type="hidden" name="update_product" value="1">
<input type="submit" value="Update Product">
</form>

<h2>Eliminar Datos Existentes De Producto</h2>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
<label for="fnum_del">Nombre del Producto a Eliminar:</label><br>
<input type="text" id="fnum_del" name="fnum_del"><br>
<input type="submit" name="delete_product" value="Delete Product">
</form>
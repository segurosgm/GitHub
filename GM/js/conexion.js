import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConexionDB {
    public static void main(String[] args) {
        // URL de conexión a la base de datos
        String url = "jdbc:mysql://localhost:3306/gmk";  // Cambia localhost por tu host si es necesario
        String usuario = "root";  // Tu usuario de MySQL
        String contrasena = "tu_contrasena";  // Tu contraseña de MySQL

        // Intentamos establecer la conexión
        try {
            // Establecer la conexión
            Connection conexion = DriverManager.getConnection(url, usuario, contrasena);
            System.out.println("Conexión exitosa a la base de datos 'gmk'.");

            // Aquí puedes agregar más código para realizar consultas o manipular la base de datos

            // Cerrar la conexión
            conexion.close();
        } catch (SQLException e) {
            System.err.println("Error de conexión: " + e.getMessage());
        }
    }
}

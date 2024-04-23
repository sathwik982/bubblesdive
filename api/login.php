<?php
if (isset($_SESSION['userId'])) {
	header("Location: /booking/admin/index.php");
	exit;
}
?>

<?php
include __DIR__ . '/../database/Connection.php';
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../helpers/urlhelpers.php';

class Auth
{
	public function dd($arr)
	{
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
		die();
	}

	public function login($data)
	{
		session_start();
		$email = $data["email"];
		$password = $data["password"];

		$db = new Connection();
		if (empty($_SERVER['HTTP_REFERER'])) {
			echo "You don't have access to this page directly.";
			exit;
		}
		$sql = "SELECT u.userId, u.fullName, u.email, u.password, u.roleId, r.roleName, u.status, ar.assign_dashboard
            FROM users u
            INNER JOIN roles r ON u.roleId = r.roleId
            LEFT JOIN assign_roles ar ON u.roleId = ar.roleId
            WHERE u.email = ?";
		$result = $db->run($sql, [$email]);

		if ($result["status"] !== "success") {
			$_SESSION["loginerror"] = "Something went wrong";
			return redirect("/booking/admin/login.php");
		}

		$userData = $result["data"][0] ?? null;
		if (!$userData || !password_verify($password, $userData['password'])) {
			$_SESSION["loginerror"] = "Email or password is wrong";
			return redirect("/booking/admin/login.php");
		}

		if ($userData['status'] == 'INACTIVE') {
			$_SESSION["loginerror"] = "Your account is inactive";
			return redirect("/booking/admin/login.php");
		}

		$_SESSION['userId'] = $userData['userId'];
		$_SESSION["auth"] = (object) $userData;

		if (isset($userData['assign_dashboard']) && $userData['assign_dashboard'] == 1) {
			return redirect("/booking/admin/index.php");
		} else {
			return redirect("/booking/admin/index.php");
		}
	}


	public function logout()
	{
		session_start();
		session_unset();
		session_destroy();
		return redirect("/booking/admin/login.php");
	}
}

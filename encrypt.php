<?php
	require_once 'mainFunction.php';
	$Encryption = new Encryption;
?>

<form method="POST">
	<textarea name="text" rows="5" cols="30" placeholder="Input text for encryption"></textarea><br>
	<button>Encrypt Text</button>	
</form>

<?php
if(isset($_POST['text'])){
	$input = $_POST['text'];
	$Encryption->encryption($input);
}
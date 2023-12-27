<?php
	require_once 'mainFunction.php';
	$Encryption = new Encryption;
?>

<form method="POST">
	<textarea name="text" rows="5" cols="30" placeholder="Input text for decryption"></textarea><br>
	<input type="text" name="key" placeholder="Input secret key"><br>
	<button>Encrypt Text</button>	
</form>

<?php
if(isset($_POST['text']) || isset($_POST['key'])){
	$text = $_POST['text'];
	$key = $_POST['key'];
	$Encryption->decryption($text, $key);
}
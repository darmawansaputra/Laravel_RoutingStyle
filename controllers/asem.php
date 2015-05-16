<?php

class asem {
	public function okes() {
		echo 'yo';
	}

	public function form() {
		echo "<form action='aksi' method='post'><input type='text' name='nama'><input type='submit'></form>";
	}

	public function aksi() {
		echo 'Selamat datang ' . $_POST['nama'];
	}
}
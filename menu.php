<?php
function hitungKataUnik($kalimat) {
    $kalimat = strtolower($kalimat);
    $kalimat = preg_replace('/[[:punct:]]/', '', $kalimat);
    $kataArray = preg_split('/\s+/', $kalimat, -1, PREG_SPLIT_NO_EMPTY);
    $kataUnik = array_unique($kataArray);
    return count($kataUnik);
}

function duaAngkaTerbesar($array) {
    if (count($array) < 2) {
        return null;
    }
    $copy = $array;
    rsort($copy);
    return array_slice($copy, 0, 2);
}

function getStatusKaryawan($tahun) {
    return ($tahun > 3) ? "karyawan tetap" : "bukan karyawan tetap";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Test Code Risalatul Kamila</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="watermark">Test Code Risalatul Kamila</div>
<?php
if (!isset($_POST['soal'])) {
?>
    <form method="POST" autocomplete="off">
        <label for="soal">Pilih nomor soal (1-5):</label>
        <select name="soal" id="soal" required>
            <option value="" disabled selected>-- Pilih Soal --</option>
            <option value="1">1 - Hitung Kata Unik</option>
            <option value="2">2 - Dua Angka Terbesar</option>
            <option value="3">3 - Status Karyawan</option>
            <option value="4">4 - Cek Ganjil, Genap, dan Habis Dibagi 4</option>
            <option value="5">5 - Segitiga Bintang</option>
        </select>
        <input type="submit" value="Jalankan">
    </form>
<?php
} else {
    $soal = $_POST['soal'];

    switch ($soal) {
        case '1':
            echo "<h3>Soal 1 - Hitung Kata Unik</h3>";
            if (!isset($_POST['kalimat'])) {
?>
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="soal" value="1">
                    <label for="kalimat">Masukkan kalimat:</label><br>
                    <textarea name="kalimat" id="kalimat" rows="3" cols="50" required></textarea><br>
                    <input type="submit" value="Hitung Kata Unik">
                </form>
<?php
            } else {
                $kalimat = trim($_POST['kalimat']);
                $hasil = hitungKataUnik($kalimat);
                echo "<div class='output'>Jumlah kata unik: <strong>$hasil</strong></div>";
                echo '<a href="menu.php">Kembali ke menu</a>';
            }
            break;

        case '2':
            echo "<h3>Soal 2 - Dua Angka Terbesar</h3>";
            if (!isset($_POST['angka'])) {
?>
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="soal" value="2">
                    <label for="angka">Masukkan array angka (pisahkan dengan koma):</label><br>
                    <input type="text" name="angka" id="angka" placeholder="misal: 1, 5, 3, 7, 2" size="50" required><br>
                    <input type="submit" value="Cari Dua Terbesar">
                </form>
<?php
            } else {
                $input = $_POST['angka'];
                $angkaArray = array_filter(array_map('intval', explode(',', $input)), function($val) {
                    return is_int($val);
                });
                $hasil = duaAngkaTerbesar($angkaArray);

                if ($hasil) {
                    echo "<div class='output'>Dua angka terbesar: <strong>" . implode(', ', $hasil) . "</strong></div>";
                } else {
                    echo "<div class='output'>Array harus memiliki minimal 2 angka.</div>";
                }
                echo '<a href="menu.php">Kembali ke menu</a>';
            }
            break;

        case '3':
            echo "<h3>Soal 3 - Status Karyawan Berdasarkan Pengalaman</h3>";

            $pegawai = [
                ['nama' => 'Budi', 'pengalaman' => 4],
                ['nama' => 'Hendra', 'pengalaman' => 2],
                ['nama' => 'Rama', 'pengalaman' => 6]
            ];

            $total = 0;
            $output = "";

            foreach ($pegawai as $p) {
                $status = getStatusKaryawan($p['pengalaman']);
                $output .= "{$p['nama']} ({$p['pengalaman']} tahun), $status\n";
                $total += $p['pengalaman'];
            }

            $output .= "\nTotal pengalaman mereka bertiga: $total tahun.";

            echo "<pre class='output'>" . htmlspecialchars($output) . "</pre>";
            echo '<a href="menu.php">Kembali ke menu</a>';
            break;

        case '4':
            echo "<h3>Soal 4 - Cek Ganjil, Genap, dan Habis Dibagi 4</h3>";

            $output = "";
            for ($i = 1; $i <= 20; $i++) {
                $output .= "$i ";
                $output .= ($i % 2 == 0) ? "ini genap\n" : "ini ganjil\n";
                if ($i % 4 == 0) {
                    $output .= "habis dibagi 4\n";
                }
            }
            echo "<pre class='output'>" . htmlspecialchars($output) . "</pre>";
            echo '<a href="menu.php">Kembali ke menu</a>';
            break;

        case '5':
            echo "<h3>Soal 5 - Segitiga Bintang</h3>";
            $baris = 11;
            $output = "";
            for ($i = 1; $i <= $baris; $i++) {
                $output .= str_repeat('*', $i) . "\n";
            }
            echo "<pre class='output'>" . htmlspecialchars($output) . "</pre>";
            echo '<a href="menu.php">Kembali ke menu</a>';
            break;

        default:
            echo "<p>Nomor soal tidak valid.</p>";
            echo '<a href="menu.php">Kembali ke menu</a>';
            break;
    }
}
?>
</body>
</html>

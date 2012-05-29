<pre><?php

Header('Content-type: text/plain;charset=utf-8');

function stripAccents($string) {
  return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function minusculesSansAccents($texte)
{
    $texte = mb_strtolower(utf8_encode($texte), 'UTF-8');
    $texte = str_replace(
        array(
            'à', 'â', 'ä', 'á', 'ã', 'å',
            'î', 'ï', 'ì', 'í', 
            'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
            'ù', 'û', 'ü', 'ú', 
            'é', 'è', 'ê', 'ë', 
            'ç', 'ÿ', 'ñ', 
        ),
        array(
            'a', 'a', 'a', 'a', 'a', 'a', 
            'i', 'i', 'i', 'i', 
            'o', 'o', 'o', 'o', 'o', 'o', 
            'u', 'u', 'u', 'u', 
            'e', 'e', 'e', 'e', 
            'c', 'y', 'n', 
        ),
        $texte
    );
 
    return $texte;        
}

$pdo = new PDO('mysql:host=localhost;dbname=ensisa_1a_trombi', 'root');

$sql = 'SELECT * FROM trombi_old';

foreach( $pdo -> query($sql) as $row )
{
  $row['prenom'] = trim($row['prenom']);
  $row['nom']    = trim($row['nom']);

  $username = minusculesSansAccents($row['prenom'] . '.' . $row['nom']);
  $password = minusculesSansAccents($row['prenom']);
  $email    = $row['email'] ?: $username . '@uha.fr';

  $email = str_replace('é', 'e', $email);

  //$user = $this->get('fos_user.util.user_manipulator')->create($username, $password, $email, 1, 0);
  echo '(' . $username . ', ' . $password . ', ' . $email . ', 1, 0)', PHP_EOL;
}


?></pre>
<?php  

session_start();
if(isset($_SESSION['login_status']))
{
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, 'https://netzwelt-devtest.azurewebsites.net/Territories/All');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
  
  
  $headers = array();
  $headers[] = 'Accept: */*';
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
  $result = curl_exec($ch);
  if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
  }
  curl_close($ch);
  
  echo "<br/>";
  $territories = json_decode($result,true);
  
  function buildTree(array $elements, $parentId = 0) {
    $branch = array();
  
    foreach ($elements as $element) {
        if ($element['parent'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
  
    return $branch;
  }
  
  function displayTerritory($TreeArray)
  {
      echo '<ul>';
      foreach($TreeArray as $arr)
      {
          if(is_array($arr)) 
          { 
            if (isset($arr['name']))
            {
              echo '<li>';
              echo $arr['name'];
              echo '</li>';
            }
            displayTerritory($arr);
          }
      }
      echo '</ul>';
  }
  
  
  $tree = buildTree($territories['data']);
  displayTerritory($tree);}
else
{
  header('Location: ./login.php');
  exit();
}
?>

<html>
  <head>
    <title>
      Home Page
    </title>
</head>

<body>
  
</body>
</html>



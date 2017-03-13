<?php
  /***********************
    Connect class
      The main connection to the database. PDO is implemented for better security.
  ************************/

  class Connect {
    private $dbc; // the variable for the database.

    /*
      Need to move out the database info and store it in a constant.php. For now,
      it works in this location.
    */
    public function __construct() {
      $this->dbc = new PDO("mysql:host=localhost;dbname=tablename;charset=utf8",
      '', '', [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,]);
      $this->dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function registerUser($fName, $lName, $zCode, $city, $tPhone, $eMail, $uName, $pWord) {
      try {
        $sth = $this->dbc->prepare("INSERT INTO Users(firstName, lastName, address,
                                    city, State, zipCode, phone, email, userName, password)
                                    VALUES(:fName, :lName, :address, :city, :state,
                                            :zCode, :tPhone, :eMail, :uName, :pWord)",
                                    array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':fName' => $fName, ':lName' => $lName, ':address' => "000 Street",
                            ':city' => $city, ':state' => "CA", ':zCode' => $zCode,
                            ':tPhone' => $tPhone, ':eMail' => $eMail, ':uName' => $uName,
                            ':pWord' => $pWord));
      } catch (PDOException $e) {
        echo $e->getMessage();
      }
    }

    public function checkZip($zip) {
      $sth = $this->dbc->prepare("SELECT * FROM ZipCodes WHERE zipCode = :zip");
      $sth->execute(array(':zip' => $zip));

      $result = $sth->fetch();

      if ($result) {
        return $result;
      } else {
        die('Must be a Solano County Zip Code');
      }
    }

    public function checkUser($user) {
      $sth = $this->dbc->prepare("SELECT * FROM Users WHERE userName = :user");
      $sth->execute(array(':user' => $user));

      $result = $sth->fetch();

      if ($result) {
        die('Username already exist!');
      } else {
        return 0;
      }
    }

    public function login($user, $pass) {
      $sth = $this->dbc->prepare("SELECT u_id, userName FROM Users
                                  WHERE userName = :user
                                  AND password = :pass",
                                array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array(":user" => $user, ":pass" => $pass));
      $result = $sth->fetch();

      if ($result) {
        $_SESSION['user_id'] = $result['u_id'];
        $_SESSION['username'] = $result['userName'];
        return 1;
      } else {
        return 0;
      }
    }

    public function grabEmail($id) {
      $sth = $this->dbc->prepare("SELECT Users.email FROM Users, PostsMeal
                                  WHERE PostsMeal.m_id = :id
                                  AND PostsMeal.mealAuthor = Users.u_id",
                                array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array(':id' => $id));
      $result = $sth->fetch();
      return $result['email'];
    }
    /*
      Currently being used for the main page to list the latest meals that have
      been entered into the database.
      Fixed: - double posting.
    */
    public function grabMeals() {
      $count = 0;
      try{
        $sth = $this->dbc->prepare("SELECT PostsMeal.mealTitle, PostsMeal.mealDate,
                                    PostsMeal.m_id, Cities.cityName, Users.userName
                                    FROM PostsMeal, Users, Cities
                                    WHERE mealReceived = 0
                                    AND PostsMeal.mealAuthor = Users.u_id
                                    AND Users.city = Cities.id
                                    ORDER BY PostsMeal.mealDate DESC",
        array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $r) {
          if ($count > 8) break;
          echo "<tr><td><a href='meal.php?id=$r->m_id'>$r->mealTitle</a></td>
                <td><a href='profile.php'>$r->userName</a></td>
                <td>$r->cityName</td></tr>";
          $count++;
        }
      } catch (PDOException $e) {
        die('Error ' . $e->getMessage());
      }
    }
    /*
      Built for the search function in the nav. I need to fix the term part,
      to stick with the rest of ther functions. $sth->execute(array(':term',
      $term)); Was not working, probably the quotation mark layouts. Will also
      need it to support arrays for food items longer than one word.
    */
    public function search($term) {
      $sth = $this->dbc->prepare("SELECT mealTitle, m_id FROM PostsMeal
                                  WHERE mealTitle LIKE '%$term%';",
                                array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_OBJ);
      foreach($result as $r) {
        echo "<a href='meal.php?id=$r->m_id'>$r->mealTitle </a><br />";
      }
    }

    public function getAccountList($id) {
      $sth = $this->dbc->prepare("SELECT m_id, mealTitle FROM PostsMeal
                                  WHERE mealAuthor = :id
                                  AND mealReceived = 0",
                                  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array(':id' => $id));
      $results = $sth->fetchAll(PDO::FETCH_OBJ);
      foreach($results as $r) {
        echo "<div class='radio'>
        <input type='radio' name='delPost' value='$r->m_id' /> $r->mealTitle
        </div><!--end of radio-->";
      }
    }
    public function getMealTitle($id) {
      $sth = $this->dbc->prepare("SELECT mealTitle
                                  FROM PostsMeal
                                  WHERE m_id = :id",
      array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array(':id' => $id));
      $result = $sth->fetch();
      return $result['mealTitle'];
    }

    public function getMealDesc($id) {
      $sth = $this->dbc->prepare("SELECT mealDesc
                                  FROM PostsMeal
                                  WHERE m_id = :id",
      array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array(':id' => $id));
      $result = $sth->fetch();
      return $result['mealDesc'];
    }
    /*
      Fixed. Displays username on meal.php
    */
    public function getMealAuth($id) {
      $sth = $this->dbc->prepare("SELECT userName
                                  FROM Users, PostsMeal
                                  WHERE m_id = :id
                                  AND PostsMeal.mealAuthor = Users.u_id",
                                  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array(':id' => $id));
      $result = $sth->fetch();
      return $result['userName'];
    }

    public function delPost($mealId) {
      try {
        $sth = $this->dbc->prepare("UPDATE PostsMeal SET mealReceived = 1
                                    WHERE m_id = :mealId",
                                    array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':mealId' => $mealId));
      } catch (PDOException $e) {
        echo $e->getMessage();
      }
    }

  public function postTheMeal($mTitle, $mDesc, $mAuth) {
    try {
      $sth = $this->dbc->prepare("INSERT INTO PostsMeal(mealTitle, mealDesc, mealAuthor, mealDate)
                                  VALUES(:mTitle, :mDesc, :mAuth, NOW())",
                                  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array(':mTitle' => $mTitle, ':mDesc' => $mDesc, ':mAuth' => $mAuth));
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function addMailList($email) {
    try {
      $sth = $this->dbc->prepare("INSERT INTO MailingList(email, subscribe)
                                  VALUES(:email, :subscribe)",
                                  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array(':email' => $email, ':subscribe' => 1));
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function adminCheckUsers() {
    $sth = $this->dbc->prepare("SELECT * FROM Users",
                              array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute();
    $result = $sth->fetchAll();
    //print_r($result);
    return $result;
  }
}
  $dbc = new Connect();
?>

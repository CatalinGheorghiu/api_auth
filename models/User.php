<?php
class User
{
    //DB stuff
    private $conn;
    private $table = 'Users';

    //User Proprieties
    public $id;
    public $email;
    public $name;
    public $password;

    //Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get users
    public function read()
    {
        //Create query
        $query = "  SELECT
                        id,
                        email,
                        name
                    FROM
                        $this->table";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();
        return $stmt;
    }

    public function read_single()
    {
        //Create query
        $query = "  SELECT
                        id,
                        email,
                        name
                    FROM
                        $this->table
                    WHERE
                        id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindValue(':id', $this->id);

        //Execute query
        $stmt->execute();

        //Fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Set proprieties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
    }

    //Create User
    public function create()
    {
        //Create query
        $query = "  INSERT INTO $this->table
                        (name,
                        email,
                        password)
                    VALUES( 
                        :name,
                        :email,
                        :password)";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Sanitize data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        //Bind data
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':password', password_hash($this->password, PASSWORD_BCRYPT));

        //Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %.\n", $stmt->error);
            return false;
        }
    }

    public function check_email()
    {
        // query to check if email exists
        $query = "  SELECT 
                        id, 
                        name, 
                        password
                    FROM   
                        $this->table 
                    WHERE 
                        email = ?
                    LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        if ($num > 0) {
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->password = $row['password'];
            return true;
        }
        return false;
    }

    //Update user
    public function update()
    {
        // if password needs to be updated
        $password_set = !empty($this->password) ? ", password = :password" : "";

        //Create query
        $query = "  UPDATE
                        $this->table
                    SET
                        name = :name,
                        email = :email
                        {$password_set}
                    WHERE
                        id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        // $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':email', $this->email);
        // $stmt->bindValue(':id', $this->id);

        // hash the password before saving to database
        if (!empty($this->password)) {
            $this->password = htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        }

        // unique ID of record to be edited
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Delete user
    public function delete()
    {
        //Create query
        $query = "  DELETE FROM
                        $this->table
                    WHERE
                        id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindValue(':id', $this->id);

        //Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %.\n", $stmt->error);
            return false;
        }
    }
}

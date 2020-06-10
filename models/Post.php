<?php
class Post
{
    //DB stuff
    private $conn;
    private $table = 'Posts';

    //Post Proprieties
    public $id;
    public $user_id;
    public $name;
    public $email;
    public $title;
    public $location;
    public $price;
    public $phone_number;
    public $created_at;
    public $mileage;
    public $power;
    public $fuel;
    public $img;
    public $registration_date;
    public $cubic_capacity;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Posts
    public function read()
    {
        //Create query
        $query = "  SELECT 
                        u.name,
                        p.id,
                        p.title,
                        p.location,
                        p.price,
                        p.user_id,
                        p.created_at as creation_time,
                        i.img_url
                    FROM
                        $this->table p
                    LEFT JOIN
                        Users u ON p.user_id = u.id
                    LEFT JOIN
                        Images i ON p.id = i.post_id
                    ORDER BY 
                        p.created_at
                    DESC
                    ";
        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();
        return $stmt;
    }

    //Get single post
    public function read_single()
    {
        //Create query
        $query = "  SELECT 
                        u.name,
                        u.email,
                        p.mileage,
                        p.power,
                        p.fuel,
                        p.registration_date,
                        p.cubic_capacity,
                        p.id,
                        p.user_id,
                        p.title,
                        p.location,
                        p.price,
                        i.img_url,
                        p.phone_number,
                        p.created_at as creation_time
                    FROM
                        $this->table p
                    LEFT JOIN
                        Users u ON p.user_id = u.id
                    LEFT JOIN
                        Images i ON p.id = i.post_id
                    WHERE
                        p.id = ?
                    LIMIT 0,1
                    ";
        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1, $this->id);
        //Execute query
        $stmt->execute();
        //Fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Set properties
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->img = $row['img_url'];
        $this->title = $row['title'];
        $this->location = $row['location'];
        $this->price = $row['price'];
        $this->phone_number = $row['phone_number'];
        $this->user_id = $row['user_id'];
        $this->creation_time = $row['creation_time'];
        $this->mileage = $row['mileage'];
        $this->power = $row['power'];
        $this->fuel = $row['fuel'];
        $this->registration_date = $row['registration_date'];
        $this->cubic_capacity = $row['cubic_capacity'];

        // return $stmt;
    }

    //Create Post
    public function create()
    {
        //Create query
        $query = "  INSERT INTO $this->table
                        (title,
                        location,
                        price,
                        img,
                        phone_number,
                        mileage,
                        power,
                        fuel,
                        registration_date,
                        cubic_capacity,
                        user_id)
                    VALUES 
                        (:title,
                        :location,
                        :price,
                        :img,
                        :phone_number,
                        :mileage,
                        :power,
                        :fuel,
                        :registration_date,
                        :cubic_capacity,
                        :user_id)";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->location = htmlspecialchars(strip_tags($this->location));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->img = htmlspecialchars(strip_tags($this->img));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->mileage = htmlspecialchars(strip_tags($this->mileage));
        $this->power = htmlspecialchars(strip_tags($this->power));
        $this->fuel = htmlspecialchars(strip_tags($this->fuel));
        $this->registration_date = htmlspecialchars(strip_tags($this->registration_date));
        $this->cubic_capacity = htmlspecialchars(strip_tags($this->cubic_capacity));
        $this->user_id = $this->user_id;

        //Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':img', $this->img);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':mileage', $this->mileage);
        $stmt->bindParam(':power', $this->power);
        $stmt->bindParam(':fuel', $this->fuel);
        $stmt->bindParam(':registration_date', $this->registration_date);
        $stmt->bindParam(':cubic_capacity', $this->cubic_capacity);
        //Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            //Print error if something goes wrong
            printf("Error: %.\n", $stmt->error);
            return false;
        }
    }

    //Update Post
    public function update()
    {
        //Create query
        $query = "  UPDATE
                        $this->table
                    SET
                        title = :title,
                        location = :location,
                        mileage = :mileage,
                        power = :power,
                        fuel = :fuel,
                        registration_date = :registration_date,
                        cubic_capacity = :cubic_capacity,
                        user_id = :user_id
                    WHERE
                        id = :id";


        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->location = htmlspecialchars(strip_tags($this->location));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->mileage = htmlspecialchars(strip_tags($this->mileage));
        $this->power = htmlspecialchars(strip_tags($this->power));
        $this->fuel = htmlspecialchars(strip_tags($this->fuel));
        $this->registration_date = htmlspecialchars(strip_tags($this->registration_date));
        $this->cubic_capacity = htmlspecialchars(strip_tags($this->cubic_capacity));
        $this->id = htmlspecialchars(strip_tags($this->id));


        //Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':mileage', $this->mileage);
        $stmt->bindParam(':power', $this->power);
        $stmt->bindParam(':fuel', $this->fuel);
        $stmt->bindParam(':registration_date', $this->registration_date);
        $stmt->bindParam(':cubic_capacity', $this->cubic_capacity);

        //Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            //Print error if something goes wrong
            printf("Error: %.\n", $stmt->error);
            return false;
        }
    }

    //Delete Post
    public function delete()
    {
        //Create Query
        $query = "  DELETE FROM
                        $this->table
                    WHERE
                        id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            //Print error if something goes wrong
            printf("Error: %.\n", $stmt->error);
            return false;
        }
    }
}

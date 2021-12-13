<?php
require_once __DIR__ .'/vendor/autoload.php';

// connect
$client = new MongoDB\Client("mongodb://localhost:27017");

//Select db
// $collection = $client->e_learning->comments;
$collection = $client->e_learning->activities;



// $query = $collection->insertOne([
//     'text' => "Normalization is the process of organizing the data of your database in the best way possible to avoid data redundancy. Data redundancy firstly takes up undesired space in your database and secondly it can be difficult to maintain. As an example if you have a username in two different tables, you would make sure that if the name changes in one place, then it needs to be changed everywhere. If this doesn't happen, the database will end up having uneven data, which in the end can be useless. For that reason we go through the normalization process. Normalization comes in different stages. We look at two stages which are the ones needed for this database design.",
//     'activity_id' => '2'
// ]);

// $query = $collection->insertOne([
//     'text' => "1st normal form

//     For a table to achieve 1NF (first normal form) it should live up to the following requirements
    
//     It should only contain atomic values (single values that can not be broken down) in its columns
//     Each column should have unique names
//     ",
//     'activity_id' => '3'
// ]);

// $query = $collection->insertOne([
//     'text' => "To achieve 2NF we should do the following

//     The table should be in 1NF
//     The table should not have partial dependency
    
//     Not having partial dependency is when the data in the table only depends on the tables Primary key (or maybe compound key) 
    
//     For the database design of “DB Journey” achieving 2NF is wanted in order for the design to be optimal.
    
//     ",
//     'activity_id' => '4'
// ]);

// $query = $collection->insertOne([
//     'text' => "When looking at the ERD for the database, looking at the actual relations between the tables are an important thing to be aware of. There are a couple of relations that are worth taking a closer look at.
//     ",
//     'activity_id' => '5'
// ]);
// $query = $collection->insertOne([
//     'text' => "One to one relationship

//     The one to one relationships are when two tables are connected where only one single row from each table is associated. 
    
//     One to many relationship
    
//     The one to many relationship is when two tables are connected and one row from table one is associated with multiple rows in table two. This can be seen in the ERD for “DB Journey” between the “topics” table and the “activities” table. To explain it further, this means that one topic (a row in the topics table) can contain multiple activities in the “activities” table, and an activity in the “activities” table can only relate to one single topic. (meaning that an activity would never occur in more than one topic).
//     ",
//     'activity_id' => '6'
// ]);
// $query = $collection->insertOne([
//     'text' => "Many to many relationships are a bit more complex than the previously mentioned relationships. The many to many relationship is when a row in table one can occur in many rows in table two, but a row in table two can also occur many times in table one. This is a relation that can not be achieved directly. In order to deal with the many to many relationship is to create a so-called “junction table” in between table one and table two. The junction table will then gather an id from both tables and create a unique “compound key” which is then the unique identifier for a relationship. When looking at the ERD for “DB Journey” a many to many relationship occurs between “users” and “topics”. This is because a user can have multiple topics but topics also can have multiple users. That is why the “user_topics” table is created, where it takes both user_id and topic_id as foreign keys, and turns these two into a unique “Compound key” which is when two values are used to create one unique value.",
//     'activity_id' => '7'
// ]);

// $query = $collection->insertOne([
//     'text' => "SQL, or Structured Query Language is the set of instructions used to interact with databases. An incredibly simple definition for such a complex subject.

//     SQL is a special purpose programming language designed for managing data stored in a relational database management system. 
    
//      SQL is the language with which a coder communicates with a database in order to manipulate the data held within it. It is their guiding hand, their voice, their fingertips dragging across a screen, helping the coder to navigate and organise the data as they see fit. It is basically how a coder converses with the machine.
//     SQL is a vital tool used by any individual who seeks to pursue a career as a database administrator. For those unfamiliar with programming languages and website architecture, the work of SQL will often go unnoticed, but those who have seen behind the curtain will know it as one of the fundamental building blocks of modern database architecture.
//     ",
//     'activity_id' => '8'
// ]);
// $query = $collection->insertOne([
//     'text' => "All operations you can do on any data can be boiled down to Create, Read, Update, and Delete (CRUD). You can create something new, you can read it, update it, and finally delete it if you wish.

//     Naturally it makes sense that SQL would have these 4 operations within the language. The following table shows the corresponding SQL command to the CRUD operation. Also, in this table you can see the HTTP equivalents. It is good to see how CRUD can be found in many ideas across computing.
//     ",
//     'activity_id' => '9'
// ]);









// $comment = $db->find();
// foreach ($comment as $c){
//     echo "<div>".$c['name']."</div>";
//     echo "<div>".$c['comment']."</div>";
// }
// echo $db;    
// phpinfo();
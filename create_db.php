<?php
$pword = "password=1234";
$db = pg_connect("host=localhost port=5432 user=postgres $pword") or die("Could not connect");

$query = "DROP DATABASE IF EXISTS web20;";
$result = pg_query($query);

$query = "CREATE DATABASE web20
		    WITH
		    OWNER = postgres
		    ENCODING = 'UTF8'
		    LC_COLLATE = 'English_United Kingdom.1252'
		    LC_CTYPE = 'English_United Kingdom.1252'
		    TABLESPACE = pg_default
		    CONNECTION LIMIT = -1
				TEMPLATE template0;";
$result = pg_query($query);

$db = pg_connect("host=localhost port=5432 dbname=web20 user=postgres $pword");

// Create extension pgcrypto for our database
$query = "CREATE EXTENSION pgcrypto;";
$result = pg_query($query);

$query = "CREATE TABLE xrhsths(
		   	user_id VARCHAR PRIMARY KEY,
		   	username VARCHAR UNIQUE NOT NULL,
			name VARCHAR,
			surname VARCHAR,
		   	password VARCHAR NOT NULL,
		   	email VARCHAR UNIQUE NOT NULL,
			eco_score DECIMAL,
		   	created_on TIMESTAMP,
		   	last_login TIMESTAMP);

		CREATE TABLE administrator(
		   	admin_id SERIAL PRIMARY KEY,
		   	username VARCHAR UNIQUE NOT NULL,
		   	password VARCHAR NOT NULL,
		   	created_on TIMESTAMP,
		   	last_login TIMESTAMP);

		CREATE TABLE locationdata(
			location_id SERIAL PRIMARY KEY,
		   	loc_timestamp TIMESTAMP NOT NULL,
			latitude NUMERIC,
			longitude NUMERIC,
			accuracy INTEGER,
			uploader VARCHAR REFERENCES xrhsths(user_id));

		CREATE TABLE activitydata(
			activity_id SERIAL PRIMARY KEY,
			type VARCHAR,
			confidence INTEGER,
			act_timestamp TIMESTAMP NOT NULL, 
			loc_id INTEGER REFERENCES locationdata(location_id));

		CREATE TABLE uploadslog(
			upload_id SERIAL PRIMARY KEY,
			uploader VARCHAR REFERENCES xrhsths(user_id),
			upload_date TIMESTAMP NOT NULL );

      	INSERT INTO administrator (username, password) VALUES ('root','support');";

pg_send_query($db, $query) or die("Failed to execute query {$query}");


//header("Location: ./index.php");

?>

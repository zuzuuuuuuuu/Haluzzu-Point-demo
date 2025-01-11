<?php

session_start();

include('dbconnect.php');

function getCurrentUser($conn, $user_id)
{
    $query = "
        SELECT users.*, agents.*, admin.*, students.*
        FROM users
        LEFT JOIN agents ON users.user_id = agents.user_id
        LEFT JOIN admin ON users.user_id = admin.user_id
        LEFT JOIN students ON users.user_id = students.user_id
        WHERE users.user_id = $user_id
    ";

    $query_run = mysqli_query($conn, $query);

    // Check if query was successful and fetch the result as an associative array
    if ($query_run && mysqli_num_rows($query_run) > 0) {
        return mysqli_fetch_assoc($query_run); // Return associative array of the user data
    } else {
        return null; // Return null if no user was found
    }
}

//admin
function getTodaySales($conn)
{
    $query = "SELECT SUM(total_price) AS total_sales FROM bookings WHERE DATE(booking_date) = CURDATE() AND payment_status = 'paid'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    return $result['total_sales'] ? $result['total_sales'] : 0;
}

function getTodaySalesByAgent($conn, $agent_id)
{
    $query = "SELECT SUM(b.total_price) AS total_sales FROM bookings b LEFT JOIN studios s ON s.studio_id = b.studio_id WHERE s.agent_id = ? AND DATE(b.booking_date) = CURDATE() AND b.payment_status = 'paid'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $agent_id);  // 'i' indicates the type is integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row['total_sales'] ? $row['total_sales'] : 0;
}

function getTotalSales($conn)
{
    $query = "SELECT SUM(total_price) AS total_sales FROM bookings WHERE payment_status = 'paid'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    return $result['total_sales'] ? $result['total_sales'] : 0;
}

function getTotalSalesByAgent($conn, $agent_id)
{
    $query = "SELECT SUM(b.total_price) AS total_sales 
              FROM bookings b 
              LEFT JOIN studios s ON s.studio_id = b.studio_id 
              WHERE s.agent_id = ? AND b.payment_status = 'paid'";
              
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $agent_id);  // 'i' indicates the type is integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row['total_sales'] ? $row['total_sales'] : 0;
}

function getAgentByUserId($conn, $user_id)
{
    $query = "SELECT a.agent_id 
              FROM agents a 
              JOIN users u ON a.user_id = u.user_id 
              WHERE u.user_id = ?";
              
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);  // 'i' for integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

function getStudentByUserId($conn, $user_id)
{
    $query = "SELECT a.student_id, u.*
              FROM students a 
              JOIN users u ON a.user_id = u.user_id 
              WHERE u.user_id = ?";
              
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);  // 'i' for integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

function getStudentByStudentId($conn, $student_id)
{
    $query = "SELECT u.* 
              FROM students a 
              JOIN users u ON a.user_id = u.user_id 
              WHERE a.student_id = ?";
              
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $student_id);  // 'i' for integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Use mysqli_fetch_assoc() to get the result as an associative array
    return mysqli_fetch_assoc($result);
}




function getTotalUsers($conn)
{
    $query = "SELECT 
                (SELECT COUNT(*) FROM students) AS total_students,
                (SELECT COUNT(*) FROM agents) AS total_agents";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    return [
        'total_students' => $result['total_students'],
        'total_agents' => $result['total_agents'],
        'total_users' => $result['total_students'] + $result['total_agents']
    ];
}

function getTotalStudios($conn)
{
    $query = "SELECT COUNT(*) AS total_studios FROM studios";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    return $result['total_studios'] ? $result['total_studios'] : 0;
}

function getTotalStudiosByAgent($conn, $agent_id)
{
    $query = "SELECT COUNT(*) AS total_studios FROM studios WHERE agent_id = $agent_id";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    return $result['total_studios'] ? $result['total_studios'] : 0;
}

function getMonthlySales($conn)
{
    $currentYear = date('Y');
    $query = "SELECT MONTH(booking_date) AS month, SUM(total_price) AS total_sales 
              FROM bookings 
              WHERE YEAR(booking_date) = $currentYear  AND payment_status = 'paid'
              GROUP BY MONTH(booking_date) 
              ORDER BY MONTH(booking_date)";

    $result = mysqli_query($conn, $query);

    // Initialize arrays for sales and month names
    $monthly_sales = array_fill(1, 12, 0); // Sales data for each month
    $month_names = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    // Populate the sales data
    while ($row = mysqli_fetch_assoc($result)) {
        $monthly_sales[(int)$row['month']] = (float)$row['total_sales'];
    }

    return [
        'sales' => $monthly_sales,
        'months' => $month_names
    ];
}

function getMonthlySalesByAgent($conn, $agent_id)
{
    $currentYear = date('Y');
    $query = "SELECT MONTH(bookings.booking_date) AS month, SUM(bookings.total_price) AS total_sales 
              FROM bookings LEFT JOIN studios ON studios.studio_id = bookings.studio_id WHERE studios.agent_id = $agent_id
              AND YEAR(bookings.booking_date) = $currentYear  AND bookings.payment_status = 'paid'
              GROUP BY MONTH(bookings.booking_date) 
              ORDER BY MONTH(bookings.booking_date)";

    $result = mysqli_query($conn, $query);

    // Initialize arrays for sales and month names
    $monthly_sales = array_fill(1, 12, 0); // Sales data for each month
    $month_names = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    // Populate the sales data
    while ($row = mysqli_fetch_assoc($result)) {
        $monthly_sales[(int)$row['month']] = (float)$row['total_sales'];
    }

    return [
        'sales' => $monthly_sales,
        'months' => $month_names
    ];
}

function getSalesByState($conn)
{
    $query = "
    SELECT s.state, COALESCE(SUM(b.total_price), 0) AS total_rent
    FROM studios s
    LEFT JOIN bookings b ON b.studio_id = s.studio_id AND b.payment_status = 'paid'
    GROUP BY s.state;";

    $result = mysqli_query($conn, $query);

    $states = [];
    $total_rents = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $states[] = $row['state'];
        $total_rents[] = (float)$row['total_rent'];
    }

    return [
        'states' => $states,
        'total_rents' => $total_rents
    ];
}

function getSalesByStateByAgent($conn, $agent_id)
{
    $query = "
    SELECT s.state, COALESCE(SUM(b.total_price), 0) AS total_rent
    FROM studios s
    LEFT JOIN bookings b ON b.studio_id = s.studio_id WHERE s.agent_id = $agent_id AND b.payment_status = 'paid'
    GROUP BY s.state;";

    $result = mysqli_query($conn, $query);

    $states = [];
    $total_rents = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $states[] = $row['state'];
        $total_rents[] = (float)$row['total_rent'];
    }

    return [
        'states' => $states,
        'total_rents' => $total_rents
    ];
}

function getAllBookingButLimit($conn, $limit)
{
    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT bookings.booking_id, bookings.booking_date, bookings.total_price, bookings.payment_status, 
               students.student_id, users.name AS student_name, studios.studio_name AS studio_name, bookings.*
        FROM bookings 
        JOIN students ON bookings.student_id = students.student_id
        JOIN users ON students.user_id = users.user_id
        JOIN studios ON bookings.studio_id = studios.studio_id
        ORDER BY bookings.created_at
        LIMIT $limit";

    return $query_run = mysqli_query($conn, $query);
}

function getAllBookingByAgentButLimit($conn, $agent_id, $limit)
{
    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT bookings.booking_id, bookings.booking_date, bookings.total_price, bookings.payment_status, 
               students.student_id, users.name AS student_name, studios.studio_name AS studio_name, bookings.* 
        FROM bookings 
        JOIN students ON bookings.student_id = students.student_id
        JOIN users ON students.user_id = users.user_id
        JOIN studios ON bookings.studio_id = studios.studio_id
        WHERE studios.agent_id = $agent_id
        ORDER BY bookings.created_at
        LIMIT $limit";

    return $query_run = mysqli_query($conn, $query);
}

function getAllBooking($conn, $limit, $offset)
{
    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT bookings.booking_id, bookings.booking_date, bookings.total_price, bookings.payment_status, 
               students.student_id, users.name AS student_name, studios.studio_name AS studio_name , bookings.*
        FROM bookings 
        JOIN students ON bookings.student_id = students.student_id
        JOIN users ON students.user_id = users.user_id
        JOIN studios ON bookings.studio_id = studios.studio_id
        ORDER BY bookings.created_at DESC
        LIMIT $limit OFFSET $offset";

    return mysqli_query($conn, $query);
}

function getAllBookingByAgent($conn, $limit, $offset, $agent_id)
{
    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT bookings.booking_id, bookings.booking_date, bookings.total_price, bookings.payment_status, 
               students.student_id, users.name AS student_name, studios.studio_name , bookings.*
        FROM bookings 
        JOIN students ON bookings.student_id = students.student_id
        JOIN users ON students.user_id = users.user_id
        JOIN studios ON bookings.studio_id = studios.studio_id
        WHERE studios.agent_id = $agent_id 
        ORDER BY bookings.created_at DESC
        LIMIT $limit OFFSET $offset";

    return mysqli_query($conn, $query);
}


function getAllBookingsByStudentId($conn, $student_id)
{
    // Escape the student_id to prevent SQL injection
    $student_id = mysqli_real_escape_string($conn, $student_id);

    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT bookings.booking_id, bookings.booking_date, bookings.total_price, bookings.payment_status, 
               students.student_id, users.name AS student_name, studios.studio_name AS studio_name, studios.*, bookings.*
        FROM bookings 
        JOIN students ON bookings.student_id = students.student_id
        JOIN users ON students.user_id = users.user_id
        JOIN studios ON bookings.studio_id = studios.studio_id
        WHERE bookings.student_id = $student_id
        ORDER BY bookings.created_at DESC";

    return mysqli_query($conn, $query);
}

function getAllStudent($conn, $limit, $offset)
{
    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT 
            students.student_id, 
            users.name AS student_name, 
            students.*, 
            users.*, 
            MAX(bookings.booking_id) AS booking_id, 
            MAX(bookings.booking_date) AS booking_date, 
            MAX(bookings.total_price) AS total_price, 
            MAX(bookings.payment_status) AS payment_status, 
            GROUP_CONCAT(DISTINCT studios.studio_name SEPARATOR ', ') AS studio_name 
        FROM students 
        JOIN users ON students.user_id = users.user_id
        LEFT JOIN bookings ON students.student_id = bookings.student_id
        LEFT JOIN studios ON bookings.studio_id = studios.studio_id
        GROUP BY students.student_id, users.user_id
        ORDER BY users.created_at DESC
        LIMIT $limit OFFSET $offset";

    return mysqli_query($conn, $query);
}

function getAllStudentById($conn, $student_id)
{
    // Escape the student_id to prevent SQL injection
    $student_id = mysqli_real_escape_string($conn, $student_id);

    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT 
            students.student_id, 
            users.name AS student_name, 
            students.*, 
            users.*, 
            MAX(bookings.booking_id) AS booking_id, 
            MAX(bookings.booking_date) AS booking_date, 
            MAX(bookings.total_price) AS total_price, 
            MAX(bookings.payment_status) AS payment_status, 
            GROUP_CONCAT(DISTINCT studios.studio_name SEPARATOR ', ') AS studio_name 
        FROM students
        JOIN users ON students.user_id = users.user_id
        LEFT JOIN bookings ON students.student_id = bookings.student_id
        LEFT JOIN studios ON bookings.studio_id = studios.studio_id
        WHERE students.student_id = $student_id
        GROUP BY students.student_id, users.user_id
        ORDER BY users.created_at DESC";

    return mysqli_query($conn, $query);
}

function getAllStudentByUserId($conn, $user_id)
{
    // Escape the student_id to prevent SQL injection
    $user_id = mysqli_real_escape_string($conn, $user_id);

    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT 
            students.student_id, 
            users.name AS student_name, 
            students.*, 
            users.*, 
            MAX(bookings.booking_id) AS booking_id, 
            MAX(bookings.booking_date) AS booking_date, 
            MAX(bookings.total_price) AS total_price, 
            MAX(bookings.payment_status) AS payment_status, 
            GROUP_CONCAT(DISTINCT studios.studio_name SEPARATOR ', ') AS studio_name 
        FROM students
        JOIN users ON students.user_id = users.user_id
        LEFT JOIN bookings ON students.student_id = bookings.student_id
        LEFT JOIN studios ON bookings.studio_id = studios.studio_id
        WHERE students.user_id = $user_id
        GROUP BY students.student_id, users.user_id
        ORDER BY users.created_at DESC";

    return mysqli_query($conn, $query);
}

function getAllAgent($conn, $limit, $offset)
{
    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT 
            agents.agent_id, 
            users.name AS name, 
            agents.*, 
            users.*, 
            GROUP_CONCAT(DISTINCT studios.studio_name SEPARATOR ', ') AS studio_name 
        FROM agents 
        JOIN users ON agents.user_id = users.user_id
        LEFT JOIN studios ON agents.agent_id = studios.agent_id
        GROUP BY agents.agent_id, users.user_id
        ORDER BY users.created_at DESC
        LIMIT $limit OFFSET $offset";

    return mysqli_query($conn, $query);
}

function getAllAgentById($conn, $agent_id)
{
    // Escape the student_id to prevent SQL injection
    $agent_id = mysqli_real_escape_string($conn, $agent_id);

    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT 
            agents.agent_id, 
            users.name AS name, 
            agents.*, 
            users.*, 
            GROUP_CONCAT(DISTINCT studios.studio_name SEPARATOR ', ') AS studio_name 
        FROM agents
        JOIN users ON agents.user_id = users.user_id
        LEFT JOIN studios ON agents.agent_id = studios.agent_id
        WHERE agents.agent_id = $agent_id
        GROUP BY agents.agent_id, users.user_id
        ORDER BY users.created_at DESC";

    return mysqli_query($conn, $query);
}

function getAllStudiosByAgentId($conn, $agent_id)
{
    // Escape the agent_id to prevent SQL injection
    $agent_id = mysqli_real_escape_string($conn, $agent_id);

    // Adjust this query to match the exact column names of your tables
    $query = "
        SELECT studios.*, agents.*, users.*
        FROM studios
        JOIN agents ON studios.agent_id = agents.agent_id
        JOIN users ON agents.user_id = users.user_id
        WHERE studios.agent_id = $agent_id
        ORDER BY studios.created_at DESC";

    return mysqli_query($conn, $query);
}

function getAllStudio($conn, $limit, $offset)
{
    // Query to fetch agent, user, and studio details
    $query = "
        SELECT 
            agents.agent_id, 
            users.name AS agent_name, 
            users.email, 
            users.phone_number,
            studios.*,
            agents.*,
            users.*
        FROM studios
        JOIN agents ON agents.agent_id = studios.agent_id
        JOIN users ON users.user_id = agents.user_id
        ORDER BY studios.created_at DESC
        LIMIT $limit OFFSET $offset";

    return mysqli_query($conn, $query);
}

function getAllStudioAgent($conn, $limit, $offset, $agent_id)
{
    // Query to fetch agent, user, and studio details
    $query = "
        SELECT 
            agents.agent_id, 
            users.name AS agent_name, 
            users.email, 
            users.phone_number,
            studios.*,
            agents.*,
            users.*
        FROM studios
        JOIN agents ON agents.agent_id = studios.agent_id
        JOIN users ON users.user_id = agents.user_id
        WHERE studios.agent_id = $agent_id
        ORDER BY studios.created_at DESC
        LIMIT $limit OFFSET $offset";

    return mysqli_query($conn, $query);
}


function getAllStudioById($conn, $studio_id)
{
    // Escape the student_id to prevent SQL injection
    $studio_id = mysqli_real_escape_string($conn, $studio_id);

    // Adjust this query to match the exact column names of your tables
    $query = "
       SELECT 
            agents.agent_id, 
            users.name AS agent_name, 
            users.email, 
            users.phone_number,
            studios.*,
            agents.*,
            users.*
        FROM studios
        JOIN agents ON agents.agent_id = studios.agent_id
        JOIN users ON users.user_id = agents.user_id
        WHERE studios.studio_id = $studio_id
        GROUP BY agents.agent_id, users.name, users.email, users.phone_number
        ORDER BY studios.created_at DESC";

    return mysqli_query($conn, $query);
}

function getTotalTable($conn, $table)
{
    $query = "SELECT COUNT(*) AS total FROM $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getTotalBookingsAgent($conn, $table, $agent_id)
{
    $query = "
        SELECT COUNT(*) AS total 
        FROM bookings 
        JOIN studios ON bookings.studio_id = studios.studio_id
        WHERE studios.agent_id = $agent_id";
        
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}


function getTotalBookingsStudent($conn, $student_id)
{
    $query = "
        SELECT COUNT(*) AS total 
        FROM bookings 
        WHERE student_id = $student_id";
        
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getTotalStudiosAgent($conn, $agent_id)
{
    $query = "
        SELECT COUNT(*) AS total 
        FROM studios 
        WHERE agent_id = $agent_id";
        
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}



function getAll($table)
{
    global $conn;
    $query = "SELECT * FROM $table";
    return $query_run = mysqli_query($conn, $query);
}

function getAllButLimit($table, $limit)
{
    global $conn;
    $query = "SELECT * FROM $table LIMIT $limit";
    return $query_run = mysqli_query($conn, $query);
}

function getSixStudios($table, $limit)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE availability_status = 'available' AND trending = 1 LIMIT $limit";
    return $query_run = mysqli_query($conn, $query);
}

function getStudioById($conn, $studio_id)
{
    $query = "SELECT * FROM studios WHERE studio_id =  $studio_id";
    return $query_run = mysqli_query($conn, $query);
}

function getSpecificStudioById($conn, $studio_id)
{
    // Using a prepared statement to prevent SQL injection
    $query = "SELECT * FROM studios WHERE studio_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $studio_id); // "i" stands for integer
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch the result as an associative array
    return mysqli_fetch_assoc($result);
}


function getStudioImages($conn, $studio_id, $limit = 4)
{
    $query = "SELECT * FROM studioimages WHERE studio_id = '$studio_id' LIMIT $limit";
    return $query_run = mysqli_query($conn, $query);
}

function getFamousLocation()
{
    global $conn;
    $query = "
                SELECT 
                    s.state,
                    s.location,
                    s.image_cover as image_cover,
                    COUNT(b.booking_id) AS booking_count,
                    COUNT(s.studio_id) AS room_count
                FROM 
                    Studios s
                LEFT JOIN 
                    Bookings b ON s.studio_id = b.studio_id
                GROUP BY 
                    s.state, s.location
                ORDER BY 
                    booking_count DESC
                LIMIT 6;
            ";
    return $query_run = mysqli_query($conn, $query);
}

function getAllAgents()
{
    global $conn;
    $query = "SELECT a.agent_id, a.business_name, a.studio_location, a.state, 
                     u.name AS full_name, u.image_profile, u.email, u.phone_number
              FROM agents a
              JOIN users u ON a.user_id = u.user_id
              ORDER BY a.agent_id ASC";
    return mysqli_query($conn, $query);
}

function getAgentById($conn, $agent_id)
{
    $query = "SELECT * FROM agents, users WHERE agents.agent_id = $agent_id AND users.user_id = agents.user_id";
    return mysqli_fetch_assoc(mysqli_query($conn, $query));
}

function getBySlug($conn, $table, $slug)
{
    $query = "SELECT * FROM $table WHERE slug='$slug' AND availability_status = 'available'";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}

function getRelated($conn, $table, $studio_id)
{
    $query = "SELECT * 
    FROM $table
    WHERE studio_id != '$studio_id' 
    ORDER BY location, state, type, agent_id";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}

// Define a function to truncate the description
function truncateDescription($text, $maxLength)
{
    if (strlen($text) > $maxLength) {
        return substr($text, 0, $maxLength) . '...';
    }
    return $text;
}

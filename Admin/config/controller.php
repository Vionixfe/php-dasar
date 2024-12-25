<?php 

// query select data
function query($query)
{
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}
// create category
function store_category($data) {
    global $db;

    $title = $data['title'];
    $slug = $data['slug'];

    // $query = "INSERT INTO categories (title, slug) VALUES ('$title', '$slug')";
    // mysqli_query($db, $query);

    //lebih aman dengan prepare statment
    $stmt = $db->prepare("INSERT INTO categories (title, slug) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $slug);
    $stmt->execute();

    return $stmt;
}

// delete category
function delete_category($id) {
    global $db;

    $query = "DELETE FROM categories WHERE id_category = $id";
    mysqli_query($db, $query);  

    return mysqli_affected_rows($db);
}


//Edit category
function update_category($post)
{
    global $db;

    $id_category = $post['id_category'];
    $title = $post['title'];
    $slug = $post['slug'];

    $query = "UPDATE categories SET title = '$title', slug = '$slug' WHERE id_category ='$id_category'";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//Store Film//
function store_film($data) {
    global $db;

    $url = sanitize($data['url']);
    $title = sanitize($data['title']);
    $slug = sanitize($data['slug']);
    $description = sanitize($data['description']);
    $release_date = sanitize($data['release_date']);
    $studio = sanitize($data['studio']);
    $category_id = (int)sanitize($data['category_id']);
    
    $query = "INSERT INTO films (url,title, slug, description, release_date, studio, category_id) VALUES ('$url','$title', '$slug', '$description', '$release_date', '$studio', '$category_id')";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}



// delete film
function delete_film($id) {
    global $db;

    $id = sanitize($id);

    $stmt = $db->prepare("DELETE FROM films WHERE id_film = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->affected_rows;
}

// Edit film
function update_film($post)
{
    global $db;

    $id_film = sanitize($post['id_film']);
    $url = sanitize($post['url']);
    $title = sanitize($post['title']);
    $slug = sanitize($post['slug']);
    $description = sanitize($post['description']);
    $release_date = sanitize($post['release_date']);
    $studio = sanitize($post['studio']);
    $is_private = (int)sanitize($post['is_private']);
    $category_id = (int)sanitize($post['category_id']);

    // Menggunakan prepared statement
    $stmt = $db->prepare("UPDATE films SET url = ?, title = ?, slug = ?, description = ?, release_date = ?, studio = ?, is_private = ?,category_id = ? WHERE id_film = ?");
    $stmt->bind_param("ssssssiii", $url, $title, $slug, $description, $release_date, $studio,$is_private, $category_id, $id_film);
    $stmt->execute();

    return $stmt->affected_rows;
}

// store user
function store_user($data)
{
    global $db;

    $username   = sanitize($data['username']);
    $email      = sanitize($data['email']);
    $password   = sanitize(password_hash($data['password'], PASSWORD_BCRYPT));
    $role       = sanitize($data['role']); // role can be 'admin' or 'operator'

    // query dengan prepare statement
    $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    $stmt->execute();

    return $stmt->affected_rows;
}

// Edit User
function edit_user($post)
{
    global $db;

    $id_user = $post['id_user'];
    $username = sanitize($post['username']);
    $email = sanitize($post['email']);
    $role = $post['role'];

    // Periksa apakah password diubah (hanya jika field password diisi)
    if (!empty($post['password'])) {
        $password = password_hash($post['password'], PASSWORD_BCRYPT);
        $query = "UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id_user = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ssssi", $username, $email, $password, $role, $id_user);
    } else {
        // Jika password kosong, jangan diubah
        $query = "UPDATE users SET username = ?, email = ?, role = ? WHERE id_user = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssi", $username, $email, $role, $id_user);
    }

    $stmt->execute();

    return $stmt->affected_rows;
}

    
// delete users
function delete_users($id) {
    global $db;

    $id = sanitize($id);

    $stmt = $db->prepare("DELETE FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->affected_rows;
}


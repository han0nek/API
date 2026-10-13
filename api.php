<?php

header("Content-Type: application/json");

$db = new PDO(
    "mysql:host=localhost;dbname=notes;charset=utf8",
    "root",
    ""
);

$method = $_SERVER["REQUEST_METHOD"];
$id = $_GET["id"] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

if ($method == "GET") {

    if ($id) {
        $q = $db->prepare("SELECT * FROM notes WHERE id=?");
        $q->execute([$id]);
        echo json_encode($q->fetch(PDO::FETCH_ASSOC));
    } else {
        echo json_encode(
            $db->query("SELECT * FROM notes")->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}

if ($method == "POST") {

    $q = $db->prepare(
        "INSERT INTO notes (notename, notetext) VALUES (?, ?)"
    );

    $q->execute([
        $data["notename"],
        $data["notetext"]
    ]);

    echo json_encode(["message" => "Dodano"]);
}

if ($method == "PUT") {

    $q = $db->prepare(
        "UPDATE notes SET notename=?, notetext=? WHERE id=?"
    );

    $q->execute([
        $data["notename"],
        $data["notetext"],
        $id
    ]);

    echo json_encode(["message" => "Zmieniono"]);
}

if ($method == "PATCH") {

    $q = $db->prepare(
        "UPDATE notes SET notename=?, notetext=? WHERE id=?"
    );

    $q->execute([
        $data["notename"],
        $data["notetext"],
        $id
    ]);

    echo json_encode(["message" => "Zmieniono"]);
}

if ($method == "DELETE") {

    $q = $db->prepare(
        "DELETE FROM notes WHERE id=?"
    );

    $q->execute([$id]);

    echo json_encode(["message" => "Usunięto"]);
}
?>

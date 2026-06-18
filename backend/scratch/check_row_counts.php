<?php
$host = 'ep-odd-sunset-adjqvh29.c-2.us-east-1.aws.neon.tech';
$port = '5432';
$database = 'neondb';
$user = 'neondb_owner';
$password = 'npg_f2oEKZR1MJGA';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname='$database';sslmode=require;options='endpoint=ep-odd-sunset-adjqvh29'";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    $tables = [
        'users', 'students', 'subjects', 'marks', 'academic_classes', 'classrooms',
        'teacher_subject_assignments', 'timetables', 'attendance_sessions', 'attendance_records',
        'remedial_actions', 'quizzes', 'quiz_questions', 'student_quiz_assignments'
    ];
    
    echo "TABLE ROW COUNTS:\n";
    foreach ($tables as $t) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM \"$t\"");
        echo "  - $t: " . $stmt->fetchColumn() . "\n";
    }
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

<?php
include 'config.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, trim($_GET['search'])) : '';
$filter = isset($_GET['type'])   ? mysqli_real_escape_string($conn, $_GET['type'])          : '';
$msg    = $_GET['msg'] ?? '';

$sql = "SELECT * FROM books WHERE 1=1";
if ($search !== '') $sql .= " AND (title LIKE '%$search%' OR author LIKE '%$search%' OR subject LIKE '%$search%')";
if ($filter !== '') $sql .= " AND type='$filter'";
$sql .= " ORDER BY created_at DESC";

$books = mysqli_query($conn, $sql);
if (!$books) die("Query failed: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বই ঘর - University Book & Note Sharing</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="header-inner">
        <div class="logo">
            <span class="logo-icon">📚</span>
            <div>
                <h1>বই ঘর</h1>
                <p>University Book &amp; Note Sharing</p>
            </div>
        </div>
        <button class="btn-upload-toggle" onclick="toggleForm()">+ বই / নোট আপলোড</button>
    </div>
</header>

<!-- UPLOAD FORM -->
<div class="upload-section" id="uploadForm" style="display:none;">
    <div class="container">
        <h2>📤 নতুন বই / নোট আপলোড করুন</h2>

        <?php if ($msg === 'success'): ?>
            <div class="alert success">✅ সফলভাবে আপলোড হয়েছে!</div>
        <?php elseif ($msg === 'error'): ?>
            <div class="alert error">❌ আপলোড ব্যর্থ হয়েছে। আবার চেষ্টা করুন।</div>
        <?php endif; ?>

        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <input type="text" name="title"         placeholder="বইয়ের নাম *"      required>
                <input type="text" name="author"        placeholder="লেখকের নাম *"      required>
            </div>
            <div class="form-row">
                <input type="text" name="subject"       placeholder="বিষয় (যেমন: পদার্থ, ইতিহাস) *" required>
                <input type="text" name="department_id" placeholder="Department / ID *"  required>
            </div>
            <div class="form-row">
                <select name="type" required>
                    <option value="">ধরন বেছে নিন *</option>
                    <option value="book">📖 বই</option>
                    <option value="note">📝 নোট</option>
                </select>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
            </div>
            <button type="submit" class="btn-submit">⬆ আপলোড করুন</button>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="container">

    <!-- SEARCH -->
    <div class="search-bar">
        <form method="GET" action="index.php">
            <input type="text" name="search" placeholder="🔍 বই, লেখক বা বিষয় খুঁজুন..." value="<?= htmlspecialchars($search) ?>">
            <select name="type">
                <option value="">সব ধরন</option>
                <option value="book"  <?= $filter==='book' ? 'selected':'' ?>>📖 বই</option>
                <option value="note"  <?= $filter==='note' ? 'selected':'' ?>>📝 নোট</option>
            </select>
            <button type="submit">খুঁজুন</button>
            <?php if ($search || $filter): ?>
                <a href="index.php" class="btn-clear">✕ ক্লিয়ার</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- BOOKS GRID -->
    <div class="books-grid">
        <?php if (mysqli_num_rows($books) === 0): ?>
            <div class="empty">😔 কোনো বই পাওয়া যায়নি।</div>
        <?php else: while ($row = mysqli_fetch_assoc($books)): ?>
            <div class="book-card">
                <div class="book-type <?= $row['type'] ?>">
                    <?= $row['type'] === 'book' ? '📖 বই' : '📝 নোট' ?>
                    <span class="file-ext"><?= strtoupper(htmlspecialchars($row['file_type'])) ?></span>
                </div>
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p class="subject">✍ লেখক: <?= htmlspecialchars($row['author']) ?></p>
                <p class="subject">📚 বিষয়: <?= htmlspecialchars($row['subject']) ?></p>
                <p class="uploader">🏢 Dept: <?= htmlspecialchars($row['department_id']) ?></p>
                <p class="date">🕐 <?= date('d M Y', strtotime($row['created_at'])) ?></p>
                <div class="card-actions">
                    <a href="<?= htmlspecialchars($row['file_path']) ?>" download class="btn-download">⬇ Download</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn-delete"
                       onclick="return confirm('এই বইটি ডিলিট করবেন?')">🗑</a>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>

<footer>
    <p>© বই ঘর — University Book &amp; Note Sharing Platform</p>
</footer>

<script src="script.js"></script>
</body>
</html>

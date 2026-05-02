# 📚 বই ঘর - Setup Instructions

## Localhost-এ চালানোর নিয়ম

### Step 1: XAMPP/WAMP চালু করুন
Apache এবং MySQL চালু করুন।

### Step 2: ফাইল রাখুন
```
C:/xampp/htdocs/boi_ghor/
```

### Step 3: Database তৈরি করুন
1. যান: http://localhost/phpmyadmin
2. `db.sql` ফাইলটি import করুন (database ও table দুটোই তৈরি হবে)

### Step 4: চালু করুন
```
http://localhost/boi_ghor/
```

### ফাইলের তালিকা
```
boi_ghor/
├── index.php      ← মূল পেজ + আপলোড ফর্ম
├── upload.php     ← আপলোড handler
├── delete.php     ← delete handler
├── config.php     ← database connection
├── style.css      ← design
├── script.js      ← JavaScript
├── db.sql         ← database setup
└── uploads/       ← আপলোড হওয়া ফাইল (auto-create)
```

### Features
✅ বই ও নোট আপলোড (PDF, DOC, DOCX, PPT, PPTX)
✅ লেখক, বিষয়, Department আলাদা ফিল্ড
✅ Download করুন
✅ বই/নোট ফিল্টার করুন
✅ Title, লেখক, বিষয় দিয়ে Search
✅ Delete করুন
✅ বাংলা ভাষায় UI

### Bug Fixes (v2)
- db.sql এ সব column যোগ করা হয়েছে
- upload.php এ author, department_id, file_type সংযুক্ত
- index.php এ upload form যোগ করা হয়েছে
- File type validation (শুধু PDF/DOC/PPT)
- uploads/ folder auto-create

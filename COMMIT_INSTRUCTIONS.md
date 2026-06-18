# Git Commit Standards

## Objective

AI wajib membuat commit secara otomatis setelah menyelesaikan perubahan yang stabil dan dapat dijalankan.

Jangan membuat commit jika:
- Masih terdapat error syntax
- Testing gagal
- File belum lengkap
- Masih ada TODO kritis

---

# Commit Format

Gunakan Conventional Commit.

Format:

<type>(<scope>): <description>

Contoh:

feat(auth): add login with Google
feat(user): add user management module
fix(document): resolve upload validation issue
refactor(report): optimize query generation
docs(api): update endpoint documentation

---

# Allowed Types

feat
fix
refactor
docs
style
test
perf
chore
security

---

# Scope Rules

Gunakan nama modul.

Contoh:

auth
user
role
permission
employee
salary
finance
inventory
cooperation
activity
dashboard
report
setting
system

Contoh:

feat(employee): add employee import feature

fix(finance): resolve duplicate transaction issue

refactor(report): simplify report service

---

# Commit Message Rules

Maksimal 72 karakter.

Gunakan bahasa Inggris.

Gunakan kata kerja aktif.

Baik:

feat(employee): add employee excel import

Buruk:

update employee

perbaikan data

coba commit

---

# Laravel Specific Rules

Jika membuat fitur baru, commit harus mencakup seluruh komponen terkait:

- Migration
- Model
- Request Validation
- Service
- Controller
- Route
- View
- Test

Jangan commit hanya sebagian implementasi.

---

# Commit Granularity

Pisahkan commit berdasarkan tujuan.

Benar:

feat(employee): add employee CRUD

feat(employee): add employee import

fix(employee): resolve email validation

Salah:

feat: employee CRUD import export validation dashboard fix

---

# Pre Commit Checklist

Sebelum commit:

- composer test berhasil
- php artisan test berhasil
- php artisan migrate status normal
- php artisan route:list tidak error
- php artisan config:clear berhasil
- php artisan optimize tidak error

---

# Branch Strategy

main
└── production

develop
└── integration

feature/*
└── development

hotfix/*
└── emergency fix

---

# Pull Request Rules

Title:

feat(employee): add employee import

Description:

## Summary
Menambahkan fitur import data pegawai dari Excel.

## Changes
- Import Excel
- Validation
- Error Handling

## Testing
- Import valid file
- Import invalid file
- Duplicate email

---

# Automatic Commit Behavior

Setelah fitur selesai:

1. Review perubahan.
2. Pastikan aplikasi berjalan normal.
3. Buat commit sesuai Conventional Commit.
4. Push ke branch aktif.
5. Jangan force push kecuali diminta.
@echo off
title EduTrack - File Creator
color 0A

echo ========================================
echo   EduTrack - File Creator
echo ========================================
echo.
echo Creating files in: %cd%
echo.

:: Create folders
if not exist "assets\css" mkdir "assets\css"
if not exist "assets\js" mkdir "assets\js"
if not exist "dashboard" mkdir "dashboard"

:: Create root PHP files
if not exist "index.php" type nul > "index.php"
if not exist "login.php" type nul > "login.php"
if not exist "signup.php" type nul > "signup.php"
if not exist "about.php" type nul > "about.php"
if not exist "contact.php" type nul > "contact.php"
if not exist "privacy-terms.php" type nul > "privacy-terms.php"

:: Create assets files
if not exist "assets\css\style.css" type nul > "assets\css\style.css"
if not exist "assets\js\main.js" type nul > "assets\js\main.js"

:: Create dashboard files
if not exist "dashboard\index.php" type nul > "dashboard\index.php"
if not exist "dashboard\students.php" type nul > "dashboard\students.php"
if not exist "dashboard\add-student.php" type nul > "dashboard\add-student.php"
if not exist "dashboard\edit-student.php" type nul > "dashboard\edit-student.php"
if not exist "dashboard\reports.php" type nul > "dashboard\reports.php"
if not exist "dashboard\profile.php" type nul > "dashboard\profile.php"

echo.
echo ========================================
echo ✅ All files created!
echo ========================================
echo.
echo 📁 Folder Structure:
echo.
echo edutrack/
echo ├── index.php
echo ├── login.php
echo ├── signup.php
echo ├── about.php
echo ├── contact.php
echo ├── privacy-terms.php
echo ├── assets/
echo │   ├── css/
echo │   │   └── style.css
echo │   └── js/
echo │       └── main.js
echo └── dashboard/
echo     ├── index.php
echo     ├── students.php
echo     ├── add-student.php
echo     ├── edit-student.php
echo     ├── reports.php
echo     └── profile.php
echo.
echo Total files: 14
echo.
pause
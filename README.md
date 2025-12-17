# Tickets App (Laravel)

## Description
Laravel application to manage tickets with full CRUD functionality.  
Data is stored in a JSON file instead of a database.

---

## Features
- Create, read, update and delete tickets
- Filter tickets by status or priority
- Automatic price calculation based on priority
- Deletion allowed only for closed tickets
- Parameter validation through middleware
- Blade views for all actions

---

## Business Logic
- Price is calculated from priority
- Only closed tickets can be deleted
- Invalid operations return an error view

---


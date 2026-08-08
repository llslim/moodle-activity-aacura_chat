# Refactoring & Activity Module Migration Guide: `mod_aacura_chat`

This guide documents the complete architectural refactoring and component rename of the AACURA Chatbot Activity Module from legacy **`mod_geniai`** to **`mod_aacura_chat`**.

---

## 1. Overview of Changes

The user-facing simulation activity module has been renamed to `mod_aacura_chat` to provide a clean, dedicated Moodle Activity Module interface.

| Entity | Legacy Reference (`v1.x`) | Updated Reference (`v2.0+`) |
| :--- | :--- | :--- |
| **Plugin Directory** | `mod/geniai/` | `mod/aacura_chat/` |
| **Frankenstyle Component** | `mod_geniai` | `mod_aacura_chat` |
| **PHP Namespace Root** | `namespace mod_geniai\...` | `namespace mod_aacura_chat\...` |
| **Main Activity Table** | `mdl_geniai` | `mdl_aacura_chat` |
| **Language String File** | `lang/en/geniai.php` | `lang/en/aacura_chat.php` |
| **Mustache Template Path** | `mod_geniai/chat` | `mod_aacura_chat/chat` |

---

## 2. Namespace & Function Mapping Table

All activity functions and renderers have been updated:

| Legacy Function / Class | Refactored Function / Class |
| :--- | :--- |
| `geniai_add_instance()` | `aacura_chat_add_instance()` |
| `geniai_update_instance()` | `aacura_chat_update_instance()` |
| `geniai_delete_instance()` | `aacura_chat_delete_instance()` |
| `geniai_supports()` | `aacura_chat_supports()` |
| `\mod_geniai\output\renderer` | `\mod_aacura_chat\output\renderer` |

---

## 3. Database Table & Instance Migration

Existing activity instances created under `mod_geniai` are migrated seamlessly:

```sql
-- Rename main activity table
RENAME TABLE mdl_geniai TO mdl_aacura_chat;

-- Update Moodle modules registry
UPDATE mdl_modules SET name = 'aacura_chat' WHERE name = 'geniai';

-- Update plugin configurations
UPDATE mdl_config_plugins SET plugin = 'mod_aacura_chat' WHERE plugin = 'mod_geniai';
```

---

## 4. Automated Upgrades for Existing Moodle Sites

To migrate existing course activities created under `mod_geniai` to `mod_aacura_chat`, run the automated CLI migration tool included with the core engine:

```bash
php local/aacura_core/cli/migrate_geniai_to_aacura.php
```

This script will migrate table definitions, instance IDs in `mdl_course_modules`, and gradebook items automatically.

# Refactoring & Activity Module Migration Guide: `mod_aacurachat`

This guide documents the complete architectural refactoring and component rename of the AACURA Chatbot Activity Module from legacy **`mod_geniai`** to **`mod_aacurachat`**.

---

## 1. Overview of Changes

The user-facing simulation activity module has been renamed to `mod_aacurachat` to provide a clean, dedicated Moodle Activity Module interface.

| Entity | Legacy Reference (`v1.x`) | Updated Reference (`v2.0+`) |
| :--- | :--- | :--- |
| **Plugin Directory** | `mod/geniai/` | `mod/aacurachat/` |
| **Frankenstyle Component** | `mod_geniai` | `mod_aacurachat` |
| **PHP Namespace Root** | `namespace mod_geniai\...` | `namespace mod_aacurachat\...` |
| **Main Activity Table** | `mdl_geniai` | `mdl_aacurachat` |
| **Language String File** | `lang/en/geniai.php` | `lang/en/aacurachat.php` |
| **Mustache Template Path** | `mod_geniai/chat` | `mod_aacurachat/chat` |

---

## 2. Namespace & Function Mapping Table

All activity functions and renderers have been updated:

| Legacy Function / Class | Refactored Function / Class |
| :--- | :--- |
| `geniai_add_instance()` | `aacurachat_add_instance()` |
| `geniai_update_instance()` | `aacurachat_update_instance()` |
| `geniai_delete_instance()` | `aacurachat_delete_instance()` |
| `geniai_supports()` | `aacurachat_supports()` |
| `\mod_geniai\output\renderer` | `\mod_aacurachat\output\renderer` |

---

## 3. Database Table & Instance Migration

Existing activity instances created under `mod_geniai` are migrated seamlessly:

```sql
-- Rename main activity table
RENAME TABLE mdl_geniai TO mdl_aacurachat;

-- Update Moodle modules registry
UPDATE mdl_modules SET name = 'aacurachat' WHERE name = 'geniai';

-- Update plugin configurations
UPDATE mdl_config_plugins SET plugin = 'mod_aacurachat' WHERE plugin = 'mod_geniai';
```

---

## 4. Automated Upgrades for Existing Moodle Sites

To migrate existing course activities created under `mod_geniai` to `mod_aacurachat`, run the automated CLI migration tool included with the core engine:

```bash
php local/aacura_core/cli/migrate_geniai_to_aacura.php
```

This script will migrate table definitions, instance IDs in `mdl_course_modules`, and gradebook items automatically.

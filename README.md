# AACURA Chatbot Activity Module (`mod_aacurachat`)

This repository contains the **Moodle Activity Module** for **AACURA** (AAC Understanding & Reflective Assistant).

---

## 📥 Installation & Setup Guide

### Step 1: Install Core Engine (`local_aacura_core`)
Before installing the activity module, install the backend engine plugin:
- **Repository**: [llslim/moodle-plugin-aacura_core_engine](https://github.com/llslim/moodle-plugin-aacura_core_engine)
- **Path**: `local/aacura_core`

### Step 2: Install Activity Module (`mod_aacurachat`)
1. Download the latest release or ZIP from [llslim/moodle-activity-aacurachat](https://github.com/llslim/moodle-activity-aacurachat).
2. Install via Moodle Administration:
   ```
   Site Administration → Plugins → Install Plugins → Install plugin from ZIP file
   ```
   Or clone directly to Moodle's `mod/` directory:
   ```bash
   git clone https://github.com/llslim/moodle-activity-aacurachat.git mod/aacurachat
   ```

---

## 🔄 Upgrading from Legacy `mod_geniai`

For sites migrating existing course activities created with legacy `mod_geniai`, run the core migration tool:

```bash
php local/aacura_core/cli/migrate_geniai_to_aacura.php
```

This tool automatically renames activity tables, updates course module instance IDs, and updates gradebook links.

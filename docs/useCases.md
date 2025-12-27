
# MEDIA
## UC-001 Upload Media
### Goal
Admin User uploads a file and gets a media ID back.

### Primary flow
1. Admin User selects a file and clicks Upload
2. System validates file size/type
3. System stores file
4. System saves metadata to DB
5. System returns media ID + URLs

### Alternatives / errors
- File too large → show error
- Unsupported type → show error
- Storage failure → rollback DB and show error

### Data needed
- media.stored_name
- media.mime_type
- media.size_bytes
- ...


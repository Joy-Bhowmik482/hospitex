Date: 2026-03-09

Action taken to fix Composer SSL error (curl error 60):

- Exported the local "Avast Web/Mail Shield Root" certificate and appended its PEM to
  `C:\xampp\php\extras\ssl\cacert.pem` so PHP/CURL trust chain validation
  succeeds on this Windows machine.
- Re-ran `composer update` successfully; packages downloaded and post-update scripts ran.
- Removed temporary export files `avast.cer` and `avast.pem` from the PHP extras SSL folder.

Notes:
- This change is local to the machine's PHP CA bundle. If you re-install XAMPP or move
  the project to another machine, repeat the CA trust step or install WSL/Docker and run Composer there.
- I did not modify global Windows root stores; only appended to the PHP `cacert.pem` used by this PHP runtime.

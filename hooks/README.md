# Git Hooks Configuration

This directory contains Git hooks configuration for automatic push on commit.

## Setup

### On Windows (PowerShell):
```powershell
.\hooks\install.ps1
```

### On macOS/Linux:
```bash
cp hooks/post-commit .git/hooks/post-commit
chmod +x .git/hooks/post-commit
```

## What it does

The `post-commit` hook automatically runs `git push` after every local commit. This ensures:
- Changes are always synchronized to the remote repository
- No need to manually run `git push` after each commit
- Workflow consistency across the team

## How it works

1. After you commit changes (via VS Code or command line)
2. The post-commit hook is triggered automatically
3. Hook runs `git push origin <current-branch>`
4. Changes are pushed to remote

## Disabling (if needed)

To temporarily disable the hook:
```bash
# Rename to disable
mv .git/hooks/post-commit .git/hooks/post-commit.disabled

# Rename back to enable
mv .git/hooks/post-commit.disabled .git/hooks/post-commit
```

## Notes

- Windows uses `post-commit.bat`, Unix/Mac uses `post-commit`
- Both versions do the same thing
- Hook silently fails if push fails (no blocking errors)
- Check git log or terminal output to verify push status

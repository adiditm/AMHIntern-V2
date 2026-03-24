import os
import subprocess
from datetime import datetime

def restore_git_timestamps():
    # Ambil list file yang dilacak git
    files = subprocess.check_output(['git', 'ls-files'], text=True).splitlines()

    for file in files:
        if os.path.exists(file):
            # Ambil tanggal commit terakhir untuk file ini
            log_date = subprocess.check_output(
                ['git', 'log', '-1', '--format=%at', file], text=True
            ).strip()

            if log_date:
                # Ubah timestamp file (mtime dan atime)
                v_time = int(log_date)
                os.utime(file, (v_time, v_time))
                print(f"Restored: {file}")

if __name__ == "__main__":
    restore_git_timestamps()

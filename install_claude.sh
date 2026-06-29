#!/usr/bin/env bash
# ============================================================
#  Claude Code Installer — Intel x86_64 (Linux / macOS)
#  Versi: 1.0
# ============================================================

set -euo pipefail

# ── Warna ──────────────────────────────────────────────────
RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'
CYAN='\033[0;36m'; BOLD='\033[1m'; NC='\033[0m'

info()    { echo -e "${CYAN}[INFO]${NC} $*"; }
success() { echo -e "${GREEN}[OK]${NC}   $*"; }
warn()    { echo -e "${YELLOW}[WARN]${NC} $*"; }
error()   { echo -e "${RED}[ERR]${NC}  $*" >&2; }
die()     { error "$*"; exit 1; }

# ── Header ─────────────────────────────────────────────────
echo -e "${BOLD}"
echo "  ╔══════════════════════════════════════╗"
echo "  ║   Claude Code Installer — Intel x64  ║"
echo "  ╚══════════════════════════════════════╝"
echo -e "${NC}"

# ── 1. Cek Arsitektur ──────────────────────────────────────
ARCH=$(uname -m)
OS=$(uname -s)

info "Arsitektur terdeteksi: ${BOLD}$ARCH${NC} (${OS})"

if [[ "$ARCH" != "x86_64" ]]; then
  die "Script ini hanya untuk Intel/AMD x86_64. Arsitektur Anda: $ARCH"
fi

# ── 2. Cek / Install Node.js ───────────────────────────────
install_node_linux() {
  info "Menginstall Node.js 22 (LTS) via NodeSource..."

  if command -v curl &>/dev/null; then
    curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -
  elif command -v wget &>/dev/null; then
    wget -qO- https://deb.nodesource.com/setup_22.x | sudo -E bash -
  else
    die "curl atau wget tidak ditemukan. Install salah satunya dulu."
  fi

  if command -v apt-get &>/dev/null; then
    sudo apt-get install -y nodejs
  elif command -v yum &>/dev/null; then
    sudo yum install -y nodejs
  elif command -v dnf &>/dev/null; then
    sudo dnf install -y nodejs
  else
    die "Package manager tidak dikenali. Install Node.js 18+ secara manual dari https://nodejs.org"
  fi
}

install_node_mac() {
  if command -v brew &>/dev/null; then
    info "Menginstall Node.js via Homebrew..."
    brew install node
  else
    die "Homebrew tidak ditemukan. Install dari https://brew.sh lalu jalankan ulang script ini."
  fi
}

check_node() {
  if ! command -v node &>/dev/null; then
    warn "Node.js tidak ditemukan."
    if [[ "$OS" == "Linux" ]]; then
      install_node_linux
    elif [[ "$OS" == "Darwin" ]]; then
      install_node_mac
    else
      die "OS tidak dikenali: $OS"
    fi
  fi

  NODE_VER=$(node --version | sed 's/v//')
  NODE_MAJOR=$(echo "$NODE_VER" | cut -d. -f1)

  if (( NODE_MAJOR < 18 )); then
    warn "Node.js versi $NODE_VER terlalu lama (minimum v18)."
    if [[ "$OS" == "Linux" ]]; then
      install_node_linux
    elif [[ "$OS" == "Darwin" ]]; then
      install_node_mac
    fi
  else
    success "Node.js v$NODE_VER ✓"
  fi
}

check_node

# ── 3. Cek npm ─────────────────────────────────────────────
if ! command -v npm &>/dev/null; then
  die "npm tidak ditemukan setelah install Node.js. Periksa instalasi Node."
fi
NPM_VER=$(npm --version)
success "npm v$NPM_VER ✓"

# ── 4. Install Claude Code ─────────────────────────────────
info "Menginstall @anthropic-ai/claude-code secara global..."

# Coba tanpa sudo dulu; fallback ke sudo jika permission error
if npm install -g @anthropic-ai/claude-code 2>/dev/null; then
  success "Claude Code berhasil diinstall!"
else
  warn "Mencoba dengan sudo..."
  sudo npm install -g @anthropic-ai/claude-code
  success "Claude Code berhasil diinstall (via sudo)!"
fi

# ── 5. Verifikasi ──────────────────────────────────────────
if ! command -v claude &>/dev/null; then
  # Coba temukan binary-nya
  CLAUDE_PATH=$(npm root -g)/../bin/claude 2>/dev/null || true
  if [[ -f "$CLAUDE_PATH" ]]; then
    warn "'claude' belum ada di PATH. Tambahkan ke ~/.bashrc atau ~/.zshrc:"
    echo -e "  ${YELLOW}export PATH=\"\$(npm bin -g):\$PATH\"${NC}"
  else
    warn "Binary 'claude' tidak ditemukan di PATH. Cek: npm bin -g"
  fi
else
  CLAUDE_VER=$(claude --version 2>/dev/null || echo "unknown")
  success "claude tersedia di PATH — versi: $CLAUDE_VER"
fi

# ── 6. Selesai ─────────────────────────────────────────────
echo ""
echo -e "${GREEN}${BOLD}══════════════════════════════════════${NC}"
echo -e "${GREEN}${BOLD}  Instalasi selesai!${NC}"
echo -e "${GREEN}${BOLD}══════════════════════════════════════${NC}"
echo ""
echo -e "  Mulai dengan:  ${BOLD}claude${NC}"
echo -e "  Dokumentasi:   ${CYAN}https://docs.claude.com/en/docs/claude-code/overview${NC}"
echo ""

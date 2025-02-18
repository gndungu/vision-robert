#!/bin/bash

# Set your project directory
PROJECT_DIR="/var/www/html"   # Change this if needed

# Set the PHP server IP and Port (for built-in server)
HOST="0.0.0.0"
PORT="8000"

echo "Starting PHP service..."

# Check if Apache is installed and start it
if command -v apache2 >/dev/null 2>&1; then
    sudo systemctl start apache2
    echo "Apache started!"
elif command -v httpd >/dev/null 2>&1; then
    sudo systemctl start httpd
    echo "Apache (httpd) started!"
else
    echo "Apache not found, starting PHP built-in server..."
    cd "$PROJECT_DIR" || exit
    php -S "$HOST:$PORT" &
    echo "PHP built-in server running on http://$HOST:$PORT"
fi

FROM php:8.0-cli

# Install required dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy PHPUnit configuration to container
COPY phpunit.xml /app/phpunit.xml

# Set working directory
WORKDIR /app

# Install PHP dependencies
COPY composer.json /app/
RUN composer install

# Copy all source files
COPY . /app/

# Run PHPUnit tests
CMD ["./vendor/bin/phpunit", "--configuration", "phpunit.xml"]

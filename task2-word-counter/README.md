# Word Frequency Counter

A simple PHP application that counts word frequency from text input and stores the result in a JSON file.

The system provides a minimal HTTP API and supports persistent storage without using any frameworks or external runtime libraries.

---

## Requirements

- PHP 8.0+ (tested on PHP 8.5.7)
- No frameworks
- No third-party runtime libraries
- PHPUnit (for testing)

Verify PHP version:

```bash
php -v
```

## Project Structure

```text
.
├── public
│   └── index.php
├── src
│   └── WordCounter.php
├── storage
│   └── data.json   (auto-created at runtime if missing)
├── tests
│   └── WordCounterTest.php
└── README.md

## Running the Application

Start the PHP built-in server:

```bash
php -S localhost:8000 -t public
```

## API Endpoints

- POST /words

Request:

{
  "text": "Love grows where kindness lives."
}

Response:

{
  "status": "ok"
}

- GET /words

Response:

{
  "love": 1,
  "grows": 1,
  "where": 1,
  "kindness": 2,
  "lives": 2
}

- GET /words/{word}

Example:

GET /words/kindness

Response:

{
  "word": "kindness",
  "count": 2
}

## Word Processing Rules

- Input is converted to lowercase
- Punctuation is removed
- Words are extracted using regex ([a-zA-Z]+)
- Each word is counted incrementally

Example:

"Love, love! LOVE"

Result:

love => 3
Storage

- All data is persisted in:

storage/data.json

Example content:
{
  "love": 2,
  "kindness": 3
}

If the file or folder does not exist, it is automatically created at runtime.

## Concurrency Handling

The application uses file locking (flock) inside WordCounter to safely handle concurrent write requests.

This prevents race conditions when multiple POST requests update the file at the same time.

## Running Tests

This project uses PHPUnit for unit testing.

- Install PHPUnit

```bash
composer require --dev phpunit/phpunit
```

- Run All Tests

Run tests using:

```bash
php vendor/bin/phpunit tests
```

Expected output:

OK (7 tests, 11 assertions)

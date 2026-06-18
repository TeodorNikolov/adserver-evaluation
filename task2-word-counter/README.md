# Word Frequency Counter

## Overview

This application provides a simple REST API for counting word frequencies across multiple text submissions.

The system supports:

* Submitting text via HTTP POST requests.
* Retrieving all word frequencies.
* Retrieving the frequency of a specific word.
* Persistent storage between requests.
* Concurrent access through file locking.

Word matching is case-insensitive and supports Unicode characters.

---

## Requirements

* PHP 8.1 or higher
* Composer

---

## Installation

Clone the repository and install dependencies:

```bash
composer install
```

Start the PHP development server:

```bash
php -S localhost:8000 public/index.php
```

The API will be available at:

```text
http://localhost:8000
```
---

## Project Structure

```text
project/
├── public/
│   └── index.php
├── src/
│   └── WordCounter.php
├── storage/
│   └── data.json (auto-created at runtime if missing)
├── tests/
│   └── WordCounterTest.php
├── composer.json
└── README.md
```

---

## API Endpoints

### POST /words

Processes text and updates word frequencies.

#### Request

```http
POST /words
Content-Type: application/json
```

```json
{
    "text": "Love grows where kindness lives."
}
```

#### Response

```json
{
    "status": "ok"
}
```

---

### GET /words

Returns all recorded words and their frequencies.

#### Request

```http
GET /words
```

#### Response

```json
{
    "grows": 1,
    "kindness": 2,
    "lives": 2,
    "love": 1,
    "where": 1
}
```

---

### GET /words/{word}

Returns the frequency of a specific word.

#### Request

```http
GET /words/kindness
```

#### Response

```json
{
    "word": "kindness",
    "count": 2
}
```

---

## Word Processing Rules

* Words are treated case-insensitively.
* Unicode characters are supported.
* Punctuation is ignored.
* Numbers are considered part of words.
* Word frequencies accumulate across multiple POST requests.

Examples:

```text
LOVE Love love
```

Results in:

```text
love = 3
```

---

## Storage

Word frequencies are stored in:

```text
storage/data.json
```

The application uses file locking (`flock`) to ensure safe concurrent access:

* Shared locks (`LOCK_SH`) for reads.
* Exclusive locks (`LOCK_EX`) for writes.

This prevents data corruption and lost updates when multiple requests are processed simultaneously.

---

## Error Handling

The API returns appropriate HTTP status codes:

| Status Code | Description             |
| ----------- | ----------------------- |
| 200         | Success                 |
| 400         | Invalid request payload |
| 404         | Endpoint not found      |
| 405         | Method not allowed      |
| 500         | Internal server error   |

---

## Running Tests

Execute the PHPUnit test suite:

```bash
php vendor/bin/phpunit tests
```

Example output:

```text
OK (16 tests, 23 assertions)
```

---

## Assumptions

* Text is submitted as JSON using the `text` field.
* Storage is file-based for simplicity.
* The application is intended as a lightweight coding challenge solution rather than a production-ready distributed system.

---

## Possible Improvements

For a production environment, the following improvements could be considered:

* Replace JSON storage with a relational database or Redis.
* Introduce dependency injection and storage abstractions.
* Add integration and load tests.
* Support pagination for large datasets.
* Add authentication and rate limiting.
* Process extremely large inputs using streaming techniques.

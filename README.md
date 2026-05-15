# Jon's AI Comics

A small private library of famous books, reimagined as comics.

Each volume is a PDF — the original story compressed into ~30 pages of comic panels, with the spine of the tale preserved. Generated with AI, curated by Jon.

**[See the gallery](https://jonathanaquino.com/jons-ai-comics/)**

## The story behind it

[Making AI comic adaptations of famous books](https://www.jona.ca/2026/05/making-ai-comic-adaptations-of-famous.html) — Jon's blog post on jona.ca about why and how.

## Current volumes

1. **Pride and Prejudice** — after Jane Austen
2. **The Lion, the Witch and the Wardrobe** — after C.S. Lewis
3. **Sense and Sensibility** — after Jane Austen
4. **Treasure Island** — after Robert Louis Stevenson

## About Jon

Jon Aquino is a software engineer in Surrey, BC. He blogs about technology, productivity, faith, and family.

- [jona.ca](https://jona.ca) — personal blog (Mental Garden)
- [Cool Tools for Catholics](https://cooltoolsforcatholics.blogspot.com) — Catholic tech finds

## How it's built

This repo is a public mirror of the `jons-ai-comics/` directory inside Jon's private `web-lab` repo. Syncing happens via `git subtree push` whenever a new comic is added.

- `index.php` — the gallery page (PHP + HTML/CSS, no framework)
- `data.json` — list of comics with title, source, description, and file paths
- `pdfs/` — the comic PDFs themselves
- `thumbnails/` — page-1 thumbnails rendered via `pdftoppm`

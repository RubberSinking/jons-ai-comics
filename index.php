<?php
$dataPath = __DIR__ . '/data.json';
$comics = [];
if (file_exists($dataPath)) {
    $raw = file_get_contents($dataPath);
    $decoded = json_decode($raw, true);
    if (is_array($decoded) && isset($decoded['comics']) && is_array($decoded['comics'])) {
        $comics = $decoded['comics'];
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jon's AI Comics</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..900;1,9..144,300..900&family=EB+Garamond:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
<style>
:root {
  --paper: #f3ebdb;
  --paper-2: #ede2cd;
  --ink: #1a1715;
  --ink-soft: #3a342d;
  --muted: #7a6f60;
  --accent: #8a2e16;
  --gold: #a98445;
  --line: rgba(26, 23, 21, 0.12);
}

* { margin: 0; padding: 0; box-sizing: border-box; }

html { -webkit-font-smoothing: antialiased; }

body {
  background-color: var(--paper);
  background-image:
    radial-gradient(at 12% 8%, rgba(169, 132, 69, 0.08) 0, transparent 45%),
    radial-gradient(at 88% 100%, rgba(138, 46, 22, 0.06) 0, transparent 50%);
  color: var(--ink);
  font-family: 'EB Garamond', Georgia, serif;
  font-size: 18px;
  line-height: 1.55;
  min-height: 100vh;
  padding: 0;
  position: relative;
}

/* Subtle paper grain */
body::before {
  content: '';
  position: fixed;
  inset: 0;
  pointer-events: none;
  z-index: 0;
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='240' height='240'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/><feColorMatrix values='0 0 0 0 0.1 0 0 0 0 0.09 0 0 0 0 0.08 0 0 0 0.05 0'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
  opacity: 0.35;
  mix-blend-mode: multiply;
}

main {
  max-width: 1280px;
  margin: 0 auto;
  padding: clamp(2.5rem, 6vw, 6rem) clamp(1.25rem, 4vw, 3rem) 6rem;
  position: relative;
  z-index: 1;
}

/* Header */
.masthead {
  border-bottom: 1px solid var(--line);
  padding-bottom: clamp(2.5rem, 5vw, 4rem);
  margin-bottom: clamp(3rem, 6vw, 5rem);
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}

.eyebrow {
  font-family: 'Fraunces', serif;
  font-variation-settings: 'opsz' 12, 'wght' 500;
  font-style: italic;
  font-size: 0.9rem;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--accent);
}

.title {
  font-family: 'Fraunces', serif;
  font-variation-settings: 'opsz' 144, 'wght' 500;
  font-size: clamp(3rem, 8.5vw, 6.5rem);
  line-height: 0.95;
  letter-spacing: -0.025em;
  color: var(--ink);
}

.title em {
  font-style: italic;
  font-variation-settings: 'opsz' 144, 'wght' 400;
  color: var(--accent);
}

.tagline {
  font-family: 'EB Garamond', serif;
  font-style: italic;
  font-size: clamp(1.1rem, 1.8vw, 1.35rem);
  color: var(--ink-soft);
  max-width: 56ch;
  margin-top: 0.5rem;
}

.collection-meta {
  display: flex;
  align-items: baseline;
  gap: 1.25rem;
  margin-top: 1.5rem;
  font-family: 'Fraunces', serif;
  font-variation-settings: 'opsz' 14, 'wght' 400;
  font-size: 0.85rem;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--muted);
}

.collection-meta .dot {
  width: 4px;
  height: 4px;
  background: var(--muted);
  border-radius: 50%;
  display: inline-block;
}

/* Grid */
.shelf {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: clamp(2rem, 4vw, 3.25rem) clamp(1.75rem, 3vw, 2.75rem);
}

/* Comic Card */
.comic {
  text-decoration: none;
  color: inherit;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  position: relative;
  transition: transform 0.35s cubic-bezier(0.2, 0.7, 0.2, 1);
}

.comic:hover { transform: translateY(-4px); }

.comic-cover {
  aspect-ratio: 1 / 1.42;
  background-color: var(--paper-2);
  background-image: linear-gradient(135deg, #d9cdb3 0%, #c8b896 100%);
  overflow: hidden;
  position: relative;
  box-shadow:
    0 1px 1px rgba(26, 23, 21, 0.04),
    0 6px 18px rgba(26, 23, 21, 0.07),
    0 24px 50px -10px rgba(26, 23, 21, 0.18);
  transition: box-shadow 0.4s cubic-bezier(0.2, 0.7, 0.2, 1);
}

.comic:hover .comic-cover {
  box-shadow:
    0 1px 1px rgba(26, 23, 21, 0.04),
    0 10px 24px rgba(26, 23, 21, 0.09),
    0 36px 70px -12px rgba(26, 23, 21, 0.28);
}

.comic-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.6s cubic-bezier(0.2, 0.7, 0.2, 1);
}

.comic:hover .comic-cover img { transform: scale(1.025); }

.comic-cover .placeholder {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Fraunces', serif;
  font-variation-settings: 'opsz' 144, 'wght' 300;
  font-style: italic;
  font-size: 3rem;
  color: rgba(26, 23, 21, 0.25);
}

/* Decorative tape / corner */
.comic-cover::after {
  content: '';
  position: absolute;
  inset: 0;
  border: 1px solid rgba(26, 23, 21, 0.18);
  pointer-events: none;
}

.comic-number {
  font-family: 'Fraunces', serif;
  font-variation-settings: 'opsz' 14, 'wght' 400;
  font-style: italic;
  font-size: 0.8rem;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--gold);
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-top: 0.25rem;
}

.comic-number::after {
  content: '';
  flex: 1;
  height: 1px;
  background: var(--line);
}

.comic-title {
  font-family: 'Fraunces', serif;
  font-variation-settings: 'opsz' 60, 'wght' 500;
  font-size: 1.55rem;
  line-height: 1.12;
  letter-spacing: -0.012em;
  color: var(--ink);
  transition: color 0.25s ease;
}

.comic:hover .comic-title { color: var(--accent); }

.comic-desc {
  font-family: 'EB Garamond', serif;
  font-size: 1.02rem;
  line-height: 1.5;
  color: var(--ink-soft);
  font-style: italic;
}

.comic-source {
  font-family: 'Fraunces', serif;
  font-variation-settings: 'opsz' 14, 'wght' 500;
  font-size: 0.78rem;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--muted);
  margin-top: 0.25rem;
}

/* Empty state */
.empty {
  border: 1px dashed var(--line);
  padding: clamp(3rem, 8vw, 6rem) 2rem;
  text-align: center;
  color: var(--muted);
}

.empty-title {
  font-family: 'Fraunces', serif;
  font-variation-settings: 'opsz' 60, 'wght' 400;
  font-style: italic;
  font-size: 1.6rem;
  color: var(--ink-soft);
  margin-bottom: 0.5rem;
}

.empty-sub {
  font-family: 'EB Garamond', serif;
  font-style: italic;
  font-size: 1.05rem;
}

/* Footer */
.colophon {
  margin-top: clamp(4rem, 8vw, 7rem);
  padding-top: 2rem;
  border-top: 1px solid var(--line);
  font-family: 'Fraunces', serif;
  font-variation-settings: 'opsz' 14, 'wght' 400;
  font-style: italic;
  font-size: 0.9rem;
  color: var(--muted);
  text-align: center;
}

.colophon a {
  color: var(--accent);
  text-decoration: none;
  border-bottom: 1px solid transparent;
  transition: border-color 0.2s ease;
}
.colophon a:hover { border-bottom-color: var(--accent); }

/* Stagger animation */
.comic {
  opacity: 0;
  animation: rise 0.7s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
}
@keyframes rise {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 640px) {
  .shelf { grid-template-columns: 1fr; gap: 2.5rem; }
  .comic-cover { max-width: 320px; margin: 0 auto; width: 100%; }
  .comic-title, .comic-desc, .comic-number, .comic-source { text-align: center; }
  .comic-number { justify-content: center; }
  .comic-number::after { display: none; }
}
</style>
</head>
<body>
<main>
  <header class="masthead">
    <span class="eyebrow">A small private library</span>
    <h1 class="title">Jon's AI <em>Comics</em></h1>
    <p class="tagline">Famous books, reimagined as comics. Each page rendered, each story compressed; the original spine of the tale preserved.</p>
    <div class="collection-meta">
      <span><?= count($comics) ?> <?= count($comics) === 1 ? 'Volume' : 'Volumes' ?></span>
      <span class="dot"></span>
      <span>Curated by Jon</span>
    </div>
  </header>

  <?php if (empty($comics)): ?>
    <div class="empty">
      <div class="empty-title">No volumes yet.</div>
      <div class="empty-sub">Drop a PDF into <code>pdfs/</code> and it will appear here.</div>
    </div>
  <?php else: ?>
    <section class="shelf">
      <?php foreach ($comics as $i => $comic):
        $title = $comic['title'] ?? 'Untitled';
        $description = $comic['description'] ?? '';
        $source = $comic['source'] ?? '';
        $pdf = $comic['pdf'] ?? '';
        $thumb = $comic['thumbnail'] ?? '';
        $num = str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT);
      ?>
        <a class="comic" href="<?= htmlspecialchars($pdf) ?>" target="_blank" rel="noopener" style="animation-delay: <?= 0.08 * $i ?>s;">
          <div class="comic-cover">
            <?php if ($thumb && file_exists(__DIR__ . '/' . $thumb)): ?>
              <img src="<?= htmlspecialchars($thumb) ?>" alt="<?= htmlspecialchars($title) ?> cover">
            <?php else: ?>
              <span class="placeholder">№<?= $num ?></span>
            <?php endif; ?>
          </div>
          <div class="comic-number">№ <?= $num ?></div>
          <div class="comic-title"><?= htmlspecialchars($title) ?></div>
          <?php if ($source): ?>
            <div class="comic-source">After <?= htmlspecialchars($source) ?></div>
          <?php endif; ?>
          <div class="comic-desc"><?= htmlspecialchars($description) ?></div>
        </a>
      <?php endforeach; ?>
    </section>
  <?php endif; ?>

  <footer class="colophon">
    Set in <em>Fraunces</em> &amp; <em>EB Garamond</em>. Pressed onto a private shelf.
  </footer>
</main>
</body>
</html>

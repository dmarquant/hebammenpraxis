<?php include_once 'util.php'; ?>
<section id="<?= $courseid ?>" class="course-list">

  <h2><?= $courselist[$courseid]['title'] ?></h2>

  <div class="course-details">
    <?php include 'courses/' . $courseid . '.php'; ?>
  </div>

  <? if (count($courselist[$courseid]['courses']) > 0): ?>
    <h3>Aktuelle Termine</h3>


    <div class="course-dates">
    <? foreach ($courselist[$courseid]['courses'] as $course): ?>
      <div class="course-separator"></div>

      <div class="course-title">
        <h4><?= $course->title ?></h4>
        <div>Kursleitung: <?= $course->instructor ?></div>
        <div>Kursort: <?= $course->location->description ?></div>
        <?php if ($course->price > 0): ?>
          <div>
            Kosten: <?= $course->price ?>€
            <?php if (property_exists($course, "price_addendum")): ?>
              <?= $course->price_addendum ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if (property_exists($course, "price_partner") && $course->price_partner > 0): ?>
          <div>Partnergebühr: <?= $course->price_partner ?>€</div>
        <?php endif; ?>
        <?php if (property_exists($course, "price_couple") && $course->price_couple > 0): ?>
          <div>Paare: <?= $course->price_couple ?>€</div>
        <?php endif; ?>
      </div>


      <div class="course-date">
        <div><nobr><?= formatDate($course->date_start) ?></nobr> - <nobr><?= formatDate($course->date_end) ?></nobr></div>
        <div>
          <?= count($course->dates) ?> Termin<? if (count($course->dates) > 1): ?>e<? endif; ?>
        </div>
        <div><small><?= formatTime($course->dates[0]->time_start) ?>-<?= formatTime($course->dates[0]->time_end) ?></small></div>
        <? foreach ($course->dates as $date): ?>
          <? if ($date->description && (str_contains($date->description, "Begleitperson") || str_contains($date->description, "Partner"))): ?>
            <div><?= formatDate($date->date) ?> mit Begleitperson</div>
          <? endif; ?>
        <? endforeach; ?>
      </div>

      <div class="course-booking">
        <? if (property_exists($course, "email")): ?>
          <div style="text-align: right;">Anmeldung per E-Mail: <a href="mailto:kontakt.yogatime@gmail.com">kontakt.yogatime@gmail.com</a></div>
        <? elseif (property_exists($course, "link")): ?>
          <div><a href="<?= $course->link ?>" class="btn">Zur Anmeldung</a></div>
        <? elseif ($course->available_space > 0): ?>
          <div><a href="<?= makeSignupUrl($courseid, $course->id) ?>" class="btn">Anmelden</a></div>
        <? else: ?>
          <div><a href="<?= makeSignupUrl($courseid, $course->id) ?>" class="btn">Warteliste</a></div>
        <? endif; ?>
      </div>
    <? endforeach; ?>
    </div>
  <? endif; ?>

</section>

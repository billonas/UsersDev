Γεια σου <?php echo $email; ?>, 
Είσαι πλέον ένας αναλυτής στο σύστημα παρακολούθησης ξενικών ειδών. Για να συνδεθείς στο σύστημα χρησιμοποίησε τον παρακάτω τυχαίο δημιουργημένο κωδικό: 
<?= $rand_password ?> 
(προτείνετε να τον αλλάξεις αμέσως μόλις συνδεθείς στο λογαριασμό σου)
Για ενεργοποίηση του λογαριασμού σου ακολούθησε τον παρακάτω σύνδεσμο:
<?php echo  $activate_url; ?>
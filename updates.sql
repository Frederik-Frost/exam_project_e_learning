UPDATE topics
SET step = 1, next_step = 2
WHERE topic_id = 1;

UPDATE topics
SET step = 2, next_step = 3
WHERE topic_id = 2;

UPDATE topics
SET step = 3, next_step = 4
WHERE topic_id = 3;

UPDATE topics
SET step = 4, next_step = 5
WHERE topic_id = 4;

UPDATE topics
SET step = 5, next_step = 6
WHERE topic_id = 5;

UPDATE topics
SET step = 6, next_step = 0
WHERE topic_id = 6;
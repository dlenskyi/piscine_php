SELECT title, summary
FROM film 
WHERE title like '%42%' OR summary like '%42%'
ORDER BY duration ASC;
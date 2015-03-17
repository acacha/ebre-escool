CREATE ALGORITHM = UNDEFINED VIEW classroom_group(
groupId,
groupCode,
groupShortName,
groupName,
groupDescription,
educationalLevelId,
grade,
mentorId
) AS SELECT group_id, codi_grup, nom_grup, nom_grup AS groupName, descripcio, nivell_educatiu, grau AS grade, tutor
FROM webfaltes.grup

CREATE ALGORITHM = UNDEFINED VIEW lesson(
lesson_id,
lesson_code,
classroom_group_code,
teacher_code,
lesson_shortname,
classrom_code,
day_code,
hour_code
) AS SELECT lesson_id,codi_llico,codi_grup,codi_professor,codi_assignatura,codi_aula,codi_dia,codi_hora
FROM webfaltes.classe



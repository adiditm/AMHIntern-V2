SHOW VARIABLES LIKE "%version%";

CREATE  FUNCTION `json_extract_c`(
details TEXT,
required_field VARCHAR (255)
) RETURNS text CHARSET latin1
BEGIN
  DECLARE search_term TEXT;
  SET details = SUBSTRING_INDEX(details, "{", -1);
  SET details = SUBSTRING_INDEX(details, "}", 1);
  SET search_term = CONCAT('"', SUBSTRING_INDEX(required_field,'$.', - 1), '"');
  IF INSTR(details, search_term) > 0 THEN
    RETURN TRIM(
      BOTH '"' FROM SUBSTRING_INDEX(
        SUBSTRING_INDEX(
          SUBSTRING_INDEX(
            details,
            search_term,
            - 1
          ),
          ',"',
          1
        ),
        ':',
        -1
      )
    );
  ELSE
    RETURN NULL;
  END IF;
END



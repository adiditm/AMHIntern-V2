INSERT INTO tb_actpcall_log (fendpoint, fcalling_for, fmethod, frequest_payload, fresponse_payload, fstatus_code, fresponse_time_ms, 
fclient_ip) VALUES ( 'https://api-sandbox.actionpay.id/v1/signature', 'getSignature', 'POST', '{\"http\":{\"header\":[\"Content-Type: 
application\\/json\",\"Authorization: Basic MWY1YjVlNjUtZjlmMC00YzkyLWEzMDQtYmQ5MWZmZGFiNzJlOlFwMm1kbEdmbU9LLXpnZjY=\",\"api-secret: 
VkI0V3RkY3FVbHgtd25XUQ==\"],\"method\":\"POST\",\"content\":\"{\\n \\\"address\\\":\\\"4345345345\\\",\\n \\\"amount\\\":,\\n 
\\\"alias\\\":\\\"-\\\",\\n \\\"bankCode\\\":\\\"014\\\",\\n \\\"remarks\\\":\\\"-1\\\",\\n \\\"refId\\\":\\\"J2025062500001\\\"\\n 
}\"}}', 'file_get_contents(https://api-sandbox.actionpay.id/v1/signature): failed to open stream: HTTP request failed! HTTP/1.1 400 Bad 
Request\r\n', NULL, '0.073', '182.253.50.110' ) 
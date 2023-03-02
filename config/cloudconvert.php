<?php
return [

    /**
     * You can generate API keys here: https://cloudconvert.com/dashboard/api/v2/keys.
     */

    'api_key' => env('CLOUDCONVERT_API_KEY', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZWE1ZWU0NjUwNTk2MzQzMzcxODM0ZDVmN2NmYWM4NTZiNWE1NzA1MWUwMTg4NjQwYzE4NThmNGI4MWI2YTE0MjRlYjE2MDZjNWVmZTU0NzYiLCJpYXQiOjE2NzY5NDM0NjguNzI3Njg3LCJuYmYiOjE2NzY5NDM0NjguNzI3Njg5LCJleHAiOjQ4MzI2MTcwNjguNzIwNDU3LCJzdWIiOiI2MjIzMDM5OCIsInNjb3BlcyI6WyJ1c2VyLnJlYWQiLCJ1c2VyLndyaXRlIiwidGFzay5yZWFkIiwidGFzay53cml0ZSIsIndlYmhvb2sucmVhZCIsIndlYmhvb2sud3JpdGUiLCJwcmVzZXQucmVhZCIsInByZXNldC53cml0ZSJdfQ.oQVOPtm-vNEfKuKyVN2ZbreKSOJWfvIKpn4OGJPAzqcE3fVei2NVCGhohU72FbDCXS5JNPbrNwcac-z1UC6gmx0nW03kRw25WByhkczrx_RqE40ARE8CV2nAmMLnMPEoac1kUTHI_eXMak-TPbA_gHmH8cOxMp-X3PuMnEPrSafAsWiLq-AUynT7dLXd2JUKMeV4h_Bjq6Z9RZF4BSkasxrxsPbR_23rSSN83JQ7GqGPJDcwwI7h-w_VEWn0rZWCP9JSEq1h9y2A1m1dF3fUK-pTSvuZPoOhCObWn7yQ1xC3TpP4pEBd2MvZgo8C8QT1ee1-Ji42pr47e28O7jHhuu5VrdHIzDDCWK4RWGC6KpbK1Q0BEe3ZdAjnM3td2uKbVDV3hMCnqBD7q5EyMIH7VSFM3Wc0aKzB6dd_nfXbA2Lbsv_UyBnXMSdDxLCk_F_VahNXAt8LJA3p9mlKpvFJj1AB8u3FJOzf67JtrtSjr3e1FU2ArYSmv2AsStu8TgTmmkW16D4jjiAhnRqNyDhBwQz3RbrvIKkdLtaXqHKDSVSADpi_VUwVKMCs5o21KKCxcO4WjmIqDnvAcb9JDO5fybNaWWZkSMZGYjJwttQCDm2Cw7DiIjV-fDLW2dK2VBYqYUYBAjdXUonHlRD8zdA6DH-Pg9psM-ceQUyK3M3NbT4
    '),

    /**
     * Use the CloudConvert Sanbox API (Defaults to false, which enables the Production API).
     */
    'sandbox' => env('CLOUDCONVERT_SANDBOX', false),

    /**
     * You can find the secret used at the webhook settings: https://cloudconvert.com/dashboard/api/v2/webhooks
     */
    'webhook_signing_secret' => env('CLOUDCONVERT_WEBHOOK_SIGNING_SECRET', '')

];

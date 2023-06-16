1.  openssl x509 -inform DER -in 00001000000506160639.cer -out 00001000000506160639.pem
2.  openssl pkcs8 -inform DER -in Claveprivada_FIEL_HIRC711126JT0_20211206_140329.key -passin pass:NxsWry2K -out Claveprivada_FIEL_HIRC711126JT0_20211206_140329.pem
3.  openssl pkcs12 -export -out Claveprivada_FIEL_HIRC711126JT0_20211206_140329.txt -inkey Claveprivada_FIEL_HIRC711126JT0_20211206_140329.pem -in hirc711126jt0.pem -passout pass:NxsWry2K


1. openssl x509 -inform DER -outform PEM -in 00001000000506160639.cer -pubkey out 00001000000506160639.cer.pem
openssl pkcs8 inform DER in aaa010101aaa_csd_01.key passin pass:a0123456789 out aaa010101aaa_csd_01.key.pem
openssl x509 text in CSD_MATRIZ_CAR930816FH0_20210111_141338.pem


openssl pkcs8 -inform DER -in CSD_MATRIZ_CAR930816FH0_20210111_141338.key -passin pass:SECU2021 -out CSD_MATRIZ_CAR930816FH0_20210111_141338.PEM
openssl dgst -out sign.bin -sign CSD_MATRIZ_CAR930816FH0_20210111_141338.PEM CadOri.txt
openssl enc -in sign.bin -a -A -out signB64.txt


 (null): Auto-Linking supplied '/Projects/iPad/SiacGob/FacebookSDKs-iOS-4.14.0/Bolts.framework/Bolts', framework linker option at /Projects/iPad/SiacGob/FacebookSDKs-iOS-4.14.0/Bolts.framework/Bolts is not a dylib


openssl x509 -in '00001000000506160639.cer' -inform DER -out '00001000000506160639.cer.pem' -outform PEM
openssl x509 -inform DER -in "00001000000506160639.cer" -noout -serial

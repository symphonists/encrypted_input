# Encrypted Input

This field acts like a normal text input, but the value stored in the database is encrypted and is therefore not human-readable. This is useful for storing data such as passwords, oAuth/API tokens or personal details. Encryption is achieved using [mcrypt](#todo) (256-bit) with a salt (key) of your own choosing.

This means that if your database is somehow compromised then your content remains safe. A hacker would need to also obtain the salt from the config file to decrypt your content.

## Usage

1. Put the `encrypted_input` folder into your `/extensions` directory
2. Enable "Field: Encrypted Input" from the System > Extensions page
3. Update the salt on the System > Preferences page
4. Add "Encrypted Input" fields to your sections

## Salt
This extension provides a default randomised salt for you. If you wish to change the value, ensure you do so **before** you begin creating entries. If the data is saved and encrypted already and you change the salt, the values can not be decrypted again!
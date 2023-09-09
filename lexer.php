<?php

function lex($input) {
    $tokens = [];
    $current_token = "";
    $state = "DEFAULT";
    
    for ($i = 0; $i < strlen($input); $i++) {
        $char = $input[$i];
        switch ($state) {
            case "DEFAULT":
                if (ctype_space($char)) {
                    continue;
                } elseif ($char == '#') {
                    $state = "COMMENT";
                } elseif (ctype_alpha($char)) {
                    $current_token .= $char;
                    $state = "IDENTIFIER";
                } elseif (ctype_digit($char)) {
                    $current_token .= $char;
                    $state = "NUMBER";
                } elseif ($char == '"') {
                    $state = "STRING";
                } else {
                    // Handle other cases like operators
                    $tokens[] = $char;
                }
                break;
            case "COMMENT":
                if ($char == "\n") {
                    $state = "DEFAULT";
                }
                break;
            case "IDENTIFIER":
                if (ctype_alnum($char) || $char == '_') {
                    $current_token .= $char;
                } else {
                    $tokens[] = $current_token;
                    $current_token = "";
                    $state = "DEFAULT";
                    $i--;  // Re-evaluate this character in the default state
                }
                break;
            case "NUMBER":
                // Handle other cases for numbers like floats
                break;
            case "STRING":
                // Handle string lexing
                break;
            // ... additional cases as necessary
        }
    }
    
    return $tokens;
}

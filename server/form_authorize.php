<?php

echo '<form method="POST" action="authorize">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="hidden" name="client_id" value="' . htmlspecialchars($_GET['client_id']) . '">
            <input type="hidden" name="redirect_uri" value="' . htmlspecialchars($_GET['redirect_uri']) . '">
            <input type="hidden" name="response_type" value="code">
            <button type="submit">Login</button>
          </form>';
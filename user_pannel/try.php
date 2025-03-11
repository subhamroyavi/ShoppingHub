$image_path = "uploads/360518052_hero-slider-1.jpg";

                            // Convert absolute path to relative URL
                            $base_path = "C:/xampp/htdocs/furniture/admin/";
                            $relative_url = str_replace($base_path, '/', $carousel['image']); // Remove the base path
                            $relative_url = str_replace('\\', '/', $relative_url); // Convert Windows backslashes to forward slashes
                            $relative_url = ltrim($relative_url, '/'); // Remove leading slash if necessary

                            // Output the correct URL
                             echo '<img src="' . htmlspecialchars($relative_url) . '" alt="Image">';

### Project installation

Before installing this project, you should ensure that your local machine has PHP7.4, MySql5.x, Node.js(latest) and [Composer](https://getcomposer.org/) installed.

After you have installed PHP, MySql, Node.js and Composer, you may setup this Laravel project via the Composer `install` command:
```$xslt
composer install
```
After the project has been installed, start your local development server and apply sql migrations using Laravel console command:
```$xslt
php artisan migrate
```
or manually:
```$xslt
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mailer_lite_api_key` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
``` 
In case you have any problems with css you can rebuild it via command:
```$xslt
npm run prod
```

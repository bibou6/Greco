# Website Template

## Bases to start a symfony project


### Includes
	* CoreBundle (One Bundle to govern them All)
		* With basic layout to include and re-use.
		* Main controller
		* Routing to Index
		* Translation Files
	* UserBundle
		* Including FosUserBundle
		* Bdd Storage
		* Role Mapping
		* traduction File for EasyAdmin
		* Including VichUploader for image upload
	* EasyAdminBundle
		* With preset User example including avatar upload
		* Translations for User
	* CoreSphereBundle
		* To use a console directly in your website for "dev" environnement
	* LiipImagineBundle
		* Used to pre-set image transformation with an example in my-account.html.twig
		* configuration in liip_imagine_config.yml
### Composer.json
	* Symfony
	* Twig
	* Doctrine
	* FosUser
	* EasyAdmin
	* CoreSphere
	* VichUploader
	
## Setting up the website
### Pre-configuration
	* Composer
### Installation
	* First copy this project into your project folder.
	* Then, in a command line shell
		* CD to /your/project/repository
		* CMD : php composer install
		* CMD : php bin/console doctrine:schema:update -f
		* CMD : php bin/console asset:install --symlink
	
### Administration Part
	* Uses EasyAdminBundle
	* Go to /admin and see the result
	* set up the configuration you want for your entities in app/easy_admin_config.yml



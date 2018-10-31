<?php
namespace ZealByte\Bundle\UserBundle\Catalog
{
	use Doctrine\Bundle\DoctrineBundle\Registry;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type as FormType;
	use ZealByte\Catalog\Form\Extension\Catalog\Type as FilterType;
	use ZealByte\Catalog\Data\Type as DataType;
	use ZealByte\Catalog\Column\Type as ColumnType;
	use ZealByte\Catalog\CatalogBuilderInterface;
	use ZealByte\Catalog\CatalogMapperInterface;
	use ZealByte\Catalog\Datum;
	use ZealByte\Catalog\Field;
	use ZealByte\Catalog\SpecAbstract;
	use ZealByte\Catalog\Data\Source\DoctrineRegistry;
	use ZealByte\Bundle\UserBundle\Entity\User;


	class UserSpec extends SpecAbstract
	{
		private $doctrine;

		public function __construct (Registry $doctrine)
		{
			$this->doctrine = $doctrine;
		}

		/**
		 * {@inheritdoc}
		 */
		public function buildCatalogMap (CatalogMapperInterface $mapper) : void
		{
			$source = (new DoctrineRegistry())
				->setEntityManager($this->doctrine->getManager())
				->setEntityId(User::class);

			$mapper
				->setDataSource($source)
				->setIdentifierField(new Field('pamId', '[pamId]', DataType\IntegerType::class))
				->setLabelField(new Field('username', '[username]', DataType\StringType::class))
				->addField(new Field('usernameCanonical', '[usernameCanonical]', DataType\StringType::class))
				->addField(new Field('userSpace', '[userSpace]', DataType\StringType::class))
				->addField(new Field('email', '[email]', DataType\EmailType::class))
				->addField(new Field('password', '[password]', DataType\StringType::class))
				->addField(new Field('salt', '[salt]', DataType\StringType::class))
				->addField(new Field('roles', '[roles]', DataType\CsvRowType::class))
				->addField(new Field('name', '[name]', DataType\StringType::class))
				->addField(new Field('lastname', '[lastname]', DataType\StringType::class))
				->addField(new Field('enabled', '[enabled]', DataType\BooleanType::class))
				->addField(new Field('dateAdded', '[dateAdded]', DataType\DateTimeType::class))
				->addField(new Field('dateModified', '[dateModified]', DataType\DateTimeType::class))
				->addField(new Field('emailCanonical', '[emailCanonical]', DataType\StringType::class))
				->addField(new Field('isBanned', '[isBanned]', DataType\BooleanType::class))
				->addField(new Field('isApproved', '[isApproved]', DataType\BooleanType::class))
				->addField(new Field('dateExpired', '[dateExpired]', DataType\DateTimeType::class))
				->addField(new Field('dateUnlocked', '[dateUnlocked]', DataType\DateTimeType::class))
				->addField(new Field('locked', '[locked]', DataType\BooleanType::class))
				->addField(new Field('expired', '[expired]', DataType\BooleanType::class))
				->addField(new Field('credentialsExpired', '[credentialsExpired]', DataType\BooleanType::class));
		}

		/**
		 * {@inheritdoc}
		 */
		public function buildCatalogView (CatalogBuilderInterface $builder) : void
		{
			$builder
				->addDatum($this->getUsernameDatum())
				->addDatum($this->getNameDatum('name', ['name','lastname']))
				->addDatum($this->getEmailDatum())
				->addDatum($this->getRolesDatum())
				->addDatum($this->getEnabledDatum())
				->addDatum($this->getDateAddedDatum());
		}

		private function getUsernameDatum () : Datum
		{
			return (new Datum('username', ['username']))
				->setColumnType(ColumnType\TextColumnType::class, [
					'class' => 'dt-column-username',
				])
				->setFormType(FormType\TextType::class);
		}

		private function getNameDatum (string $name, array $fields) : Datum
		{
			return (new Datum($name, $fields))
				->setColumnType(ColumnType\TextColumnType::class)
				->setFormType(FormType\TextType::class, []);
		}

		private function getEmailDatum () : Datum
		{
			return (new Datum('email_address', ['email']))
				->setColumnType(ColumnType\TextColumnType::class)
				->setFormType(FormType\EmailType::class);
		}

		private function getRolesDatum () : Datum
		{
			return (new Datum('roles', ['roles']))
				->setColumnType(ColumnType\RollUpColumnType::class, [
					'orderable' => false,
					'searchable' => false,
				]);
		}

		private function getEnabledDatum () : Datum
		{
			return (new Datum('enabled', ['enabled']))
				->setColumnType(ColumnType\CheckColumnType::class, [
					'orderable' => false,
					'searchable' => false,
				])
				->setFilterType(FormType\ChoiceType::class, [
					'choices' => [
						'go.yes' => true,
						'go.no' => false,
					],
					'placeholder' => 'Any',
				])
				->setFormType(FormType\CheckboxType::class);
		}

		private function getDateAddedDatum () : Datum
		{
			return (new Datum('date_created', ['dateAdded']))
				->setColumnType(ColumnType\DateTimeColumnType::class, [
					'defaultContent' => 'Never',
					'format' => 'm/d/Y',
					'searchable' => false,
					'visible' => false,
				])
				->setFormType(FormType\DateTimeType::class, [
					'date_widget' => 'single_text',
					'time_widget' => 'single_text',
				]);
		}

	}
}

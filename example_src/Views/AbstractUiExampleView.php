<?php
namespace Fortifi\UiExample\Views;

use Cubex\View\ViewModel;
use Fortifi\Ui\Ui;
use Packaged\DocBlock\DocBlockParser;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Core\ISafeHtmlProducer;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Text\HeadingFour;
use Packaged\Glimpse\Tags\Text\HeadingOne;
use Packaged\Glimpse\Tags\Text\Paragraph;
use Packaged\Helpers\Strings;

abstract class AbstractUiExampleView extends ViewModel
{
  /**
   * Automatically build the available UI parts based on methods in the class
   * grouping by the docblock @group
   *
   * @return array
   */
  public function getMethods()
  {
    $methods = [];
    $reflect = new \ReflectionObject($this);
    foreach($reflect->getMethods(\ReflectionMethod::IS_FINAL) as $method)
    {
      $doc = DocBlockParser::fromMethod($this, $method->name);
      $group = $doc->getTag('group');
      if($group === null)
      {
        continue;
      }
      if(!isset($methods[$group]))
      {
        $methods[$group] = [];
      }
      $methods[$group][] = $method->name;
    }
    return $methods;
  }

  /**
   * @return ISafeHtmlProducer
   */
  public function render()
  {
    $output = new Div();
    $groups = $this->getMethods();
    foreach($groups as $group => $methods)
    {
      $output->appendContent(
        Div::create(new HeadingOne(Strings::titleize($group)))
          ->addClass('content-container')
      );

      foreach($methods as $method)
      {
        $reflect = new \ReflectionMethod($this, $method);
        $parsed = DocBlockParser::fromMethod($this, $method);
        $code = $this->_getCode($reflect);

        $id = Strings::randomString(4);
        $toggledCode = new Div();
        $toggledCode->appendContent(
          new HeadingFour(
            (new Link('#', Strings::titleize($method)))
              ->setAttribute(
                'onclick',
                '$(\'#code-' . $id . '\')'
                . '.toggleClass(\'' . Ui::HIDE . '\');'
                . 'return false;'
              )
          )
        );
        $code = new SafeHtml(
          str_replace(
            '<span style="color: #0000BB">&lt;?php&nbsp;</span>',
            '',
            highlight_string('<?php ' . $code, true)
          )
        );
        $toggledCode->appendContent(
          Div::create()
            ->appendContent(HtmlTag::createTag('pre', [], $code))
            ->addClass(Ui::HIDE)
            ->setId('code-' . $id)
        );

        $methRow = Div::create()->addClass('content-container');
        $methRow->appendContent($toggledCode);
        $methRow->appendContent(new Paragraph($parsed->getSummary()));

        $methRow->appendContent($this->$method());

        $output->appendContent($methRow);
      }
    }
    return $output;
  }

  /**
   * Get the source code for the method
   *
   * @param \ReflectionMethod $method
   *
   * @return string
   */
  protected function _getCode(\ReflectionMethod $method)
  {
    $filename = $method->getFileName();
    $start_line = $method->getStartLine() + 1;
    $end_line = $method->getEndLine() - 1;
    $length = $end_line - $start_line;

    $source = file($filename);
    return preg_replace(
      '/^\s{4}/m',
      '',
      implode("", array_slice($source, $start_line, $length))
    );
  }
}

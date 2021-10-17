<?php
namespace Composer2Nix\Sources;
use PNDP\NixGenerator;
use PNDP\AST\NixExpression;
use PNDP\AST\NixFunInvocation;

/**
 * Represents a Git dependency.
 */
class GitSource extends Source
{
	/**
	 * Constructs a new Git dependency instance.
	 *
	 * @param array $package An array of package configuration properties
	 * @param array $sourceObj An array of download properties
	 */
	public function __construct(array $package, array $sourceObj)
	{
		parent::__construct($package, $sourceObj);
	}

	/**
	 * @see Source::fetch()
	 */
	public function fetch()
	{
	}

	/**
	 * @see NixASTNode::toNixAST()
	 */
	public function toNixAST()
	{
		$ast = parent::toNixAST();

		$ast["src"] = new NixFunInvocation(new NixExpression("builtins.fetchGit"), array(
			"name" => strtr($this->package["name"], "/", "-").'-'.$this->sourceObj["reference"],
			"url" => $this->sourceObj["url"],
			"rev" => $this->sourceObj["reference"],
			"allRefs" => true,
		));

		return $ast;
	}
}
?>

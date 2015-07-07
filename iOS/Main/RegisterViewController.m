//
//  RegisterViewController.m
//  HW Santa
//
//  Created by Austin Chan on 11/24/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <AudioToolbox/AudioToolbox.h>
#import "RegisterViewController.h"
#import "TheNavigationController.h"
#import "SantaModel.h"
#import "GameState.h"
@interface RegisterViewController (){
    NSMutableData *responseData;
    BOOL isRequesting;
    
    NSString *fieldName;
    NSString *fieldPassword;
}

@end

@implementation RegisterViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        
    }
    return self;
}

// Delegate method for UITextFieldDelegate to move everything up onFocus
- (void)textFieldDidBeginEditing:(UITextField *)sender
{
    [self activateRegisterMode];
}

- (BOOL)textFieldShouldReturn:(UITextField *)field{
    if(field == self.emailField){
        [field resignFirstResponder];
        [self.passwordField becomeFirstResponder];
    }else if(field == self.passwordField){
        [field resignFirstResponder];
        [self.confirmPasswordField becomeFirstResponder];
    }else{
        [self registerForm];
    }
    return NO;
}

// Moves everything up 
- (void)activateRegisterMode{
    [UIView beginAnimations:nil context:nil];
    [UIView setAnimationDuration:.25];
    [UIView setAnimationCurve:UIViewAnimationCurveEaseInOut];
    self.view.center = CGPointMake(originalCenter.x, 70);
    self.imageView.alpha = .2;
    self.signUpLabel.alpha = 0;
    self.cancelButton.alpha = 1;
    self.registerButton.alpha = 1;
    
    [UIView commitAnimations];
}

// Moves everything back into normal position
- (void)deactivateRegisterMode{
    [UIView beginAnimations:nil context:nil];
    [UIView setAnimationDuration:.4];
    self.view.center = originalCenter;
    self.imageView.alpha = 1;
    self.signUpLabel.alpha = 1;
    self.cancelButton.alpha = 0;
    self.registerButton.alpha = 0;
    [self.view endEditing:YES];

    
    [UIView commitAnimations];
}

// When the cancel button is clicked
- (IBAction)cancelAction:(id)sender {
    [self deactivateRegisterMode];
}

// When the register button is clicked
- (IBAction)registerAction:(id)sender {
    if(isRequesting)return;
    [self registerForm];
}

- (void)registerForm{
    NSString *email = self.emailField.text;
    NSString *password1 = self.passwordField.text;
    NSString *password2 = self.confirmPasswordField.text;
    
    if([email length] == 0 || [password1 length] == 0 || [password2 length] == 0){
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Hey" message:@"Please don't leave anything blank" delegate:self cancelButtonTitle:@"Ok" otherButtonTitles: nil];
        [alert show];
        return;
    }else if([password1 length] < 4){
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Hey" message:@"Passwords must be at least 4 characters" delegate:self cancelButtonTitle:@"Ok" otherButtonTitles: nil];
        [alert show];
        return;
    }else if(![password1 isEqualToString:password2]){
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Hey" message:@"The passwords don't match" delegate:self cancelButtonTitle:@"Ok" otherButtonTitles: nil];
        [alert show];
        return;
    }
    
    fieldName = email;
    fieldPassword = password1;
    
    isRequesting = YES;
    NSString *sendString = [NSString stringWithFormat:@"http://hwsanta.com/app/register.php?username=%@&password=%@", email,password1];
    NSURLRequest *request = [NSURLRequest requestWithURL:[NSURL URLWithString:[sendString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]]];
    
    [[NSURLConnection alloc] initWithRequest:request delegate:self];
    
}

// When the view did load
- (void)viewDidLoad
{
    [super viewDidLoad];
    	
    originalCenter = CGPointMake(self.view.center.x, 230);
    self.cancelButton.alpha = 0;
    self.registerButton.alpha = 0;
    
    [self prepButtons];
    [self prepTextFields];
    [self prepTheBackground];
    [self prepSwipeToSignIn];
}

- (void)viewDidAppear:(BOOL)animated{
    [super viewDidAppear:animated];
    
    [self.navigationController setNavigationBarHidden:YES animated:YES];
    [self deactivateRegisterMode];
}

// -------------------------------------------------------------------------
- (void)prepButtons{
    UIImage *orangeImage = [[UIImage imageNamed:@"orangeButton.png"]
                            resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    UIImage *orangeImageHighlight = [[UIImage imageNamed:@"orangeButtonHighlight.png"]
                                     resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    // Set the background for any states you plan to use
    [self.cancelButton setBackgroundImage:orangeImage forState:UIControlStateNormal];
    [self.cancelButton setBackgroundImage:orangeImageHighlight forState:UIControlStateHighlighted];
    
    UIImage *greenImage = [[UIImage imageNamed:@"greenButton.png"]
                            resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    UIImage *greenImageHighlight = [[UIImage imageNamed:@"greenButtonHighlight.png"]
                                     resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    // Set the background for any states you plan to use
    [self.registerButton setBackgroundImage:greenImage forState:UIControlStateNormal];
    [self.registerButton setBackgroundImage:greenImageHighlight forState:UIControlStateHighlighted];
}
- (void)prepTextFields{
    self.emailField.leftView = [[UIView alloc] initWithFrame:CGRectMake(0,0,5,32)];
    self.emailField.leftViewMode = UITextFieldViewModeAlways;
    self.passwordField.leftView = [[UIView alloc] initWithFrame:CGRectMake(0,0,5,32)];
    self.passwordField.leftViewMode = UITextFieldViewModeAlways;
    self.confirmPasswordField.leftView = [[UIView alloc] initWithFrame:CGRectMake(0,0,5,32)];
    self.confirmPasswordField.leftViewMode = UITextFieldViewModeAlways;
}
- (void)prepTheBackground{
    UIColor *backgroundColor = [[UIColor alloc] initWithPatternImage:[UIImage imageNamed:@"debut_light.png"]];
    self.view.backgroundColor = backgroundColor;
}
- (void)prepSwipeToSignIn{
    UISwipeGestureRecognizer *sgr = [[UISwipeGestureRecognizer alloc] initWithTarget:self action:@selector(swipedUpToSignIn)];
    [sgr setDirection:(UISwipeGestureRecognizerDirectionUp)];
    [self.swipeToSignIn addGestureRecognizer:sgr];
    self.swipeToSignIn.backgroundColor = [[UIColor alloc] initWithPatternImage:[UIImage imageNamed:@"redoneGreen.png"]];
}
// -------------------------------------------------------------------------

// When the bottom bar is swiped up
- (void)swipedUpToSignIn{
    [(TheNavigationController *)[self navigationController] swipedUpToSignIn];
}


















- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response
{
    responseData = [[NSMutableData alloc] init];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
    [responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error
{
    isRequesting = NO;
    [[[UIAlertView alloc] initWithTitle:@"Error" message:@"Could not connect to server" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    isRequesting = NO;
    NSString *response = [[NSString alloc] initWithData:responseData encoding: NSASCIIStringEncoding];
    
    if([response isEqualToString:@"fail"]){
        return;
    }else if([response isEqualToString:@"late"]){
        [[[UIAlertView alloc] initWithTitle:@"Too Late" message:@"Sorry. Signup has ended" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
    }else if([response isEqualToString:@"used"]){
        [[[UIAlertView alloc] initWithTitle:@"Taken" message:@"Sorry. That email is already in use" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
    }else{
        [[GameState sharedGameState] setUserID:response];
        [(TheNavigationController *)[self navigationController] nextAfterRegister];
    }
}


@end
